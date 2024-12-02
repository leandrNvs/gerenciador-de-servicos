const form = document.querySelector('form');
const submit = document.querySelector('form button[type="submit"]');

const fields = {
    name: 'alpha|min:1',
    phone: 'numeric|min:1|max:11',
    cpf: 'numeric|min:1|max:11',
    address: 'alphanumeric|min:1',
    brand: 'alpha|min:1',
    model: 'alphanumeric|min:1',
    year: 'numeric|min:1|max:4',
    plate: 'alphanumeric|min:1',
    color: 'alpha|min:1',
    km: 'numeric|min:1',
    fuel: 'numeric|min:1',
    reported_defect: 'optional|alphanumeric|max:500',
    problem_found: 'optional|alphanumeric|max:500',
};

// form.addEventListener('submit', function(e) {
//     Object.keys(fields).forEach(field => removeError(this[field]));

//     let error = 0;

//     for(const field in fields) {
//         const rules = fields[field].split('|');

//         const skip = (rules.includes('optional') && this[field].value === '');

//         if(!skip) {
//             if(rules.indexOf('optional') >= 0) {
//                 rules.splice(rules.indexOf('optional'), 1);
//             }

//             for(const rule of rules) {
//                 const parameters = rule.split(':');
//                 const index = parameters.shift();

//                 parameters.push(this[field].value);

//                 if(validation[index].rule(...parameters)) {
//                     const message = typeof(validation[index].message) == 'function'
//                         ? validation[index].message(...parameters)
//                         : validation[index].message;

//                     setError(this[field], message);
//                     window.scrollTo(0, 0);
//                     ++error;
//                 }
//             }
//         }
//     }

//     if(error > 0) e.preventDefault();
// });

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