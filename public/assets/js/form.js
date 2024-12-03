const form = document.querySelector('form');
const submit = document.querySelector('form button[type="submit"]');

form.addEventListener('submit', function(e) {
    Object.keys(fields).forEach(field => removeError(this[field]));

    let error = 0;

    for(const field in fields) {
        const rules = fields[field].split('|');

        const skip = (rules.includes('optional') && this[field].value === '');

        if(!skip) {
            if(rules.indexOf('optional') >= 0) {
                rules.splice(rules.indexOf('optional'), 1);
            }

            for(const rule of rules) {
                const parameters = rule.split(':');
                const index = parameters.shift();

                parameters.push(this[field].value);

                if(validation[index].rule(...parameters)) {
                    const message = typeof(validation[index].message) == 'function'
                        ? validation[index].message(...parameters)
                        : validation[index].message;

                    setError(this[field], message);
                    window.scrollTo(0, 0);
                    ++error;
                }
            }
        }
    }

    if(error > 0) e.preventDefault();
});

const validation = {
    alpha: {
        rule: (...value) => !/^[a-zA-Z\s]+$/.test(value[0]),
        message: 'o campo deve conter apenas letras e espaços.'
    },
    numeric: {
        rule: (...value) => !/^[0-9]+$/.test(value[0]),
        message: 'o campo deve conter apenas números.'
    },
    alphanumeric: {
        rule: (...value) => !/^[0-9a-zA-Z\s]+$/.test(value[0]),
        message: 'o campo deve conter apenas letras, números e espaços.'
    },
    min: {
        rule: (...value) => +value[0] > value[1].length,
        message: (...value) => +value[0] === 1? 'o campo é obrigatório' : `o campo deve conter no mínimo ${value[0]} caracteres.`
    },
    max: {
        rule: (...value) => +value[0] < value[1].length,
        message: (...value) => `o campo deve conter no máximo ${value[0]} caracteres.`
    },
};

function setError(element, message) {
    const el = element.parentElement.children[2];

    el.textContent = message;
    el.style.display = 'block';
}

function removeError(element) {
    const el = element.parentElement.children[2];

    el.textContent = null;
    el.style.display = 'none';
}