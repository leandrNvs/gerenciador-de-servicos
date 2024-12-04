const form = document.querySelector('form');
const submit = document.querySelector('form button[type="submit"]');

form.phone.addEventListener('keyup', function() {
    if(this.value.length == 11) {
        this.value = this.value.replace(/([\d]{2})([\d]{5})([\d]{4})/, '($1) $2-$3');
    }
});

form.cpf.addEventListener('keyup', function() {
    if(this.value.length == 11) {
        this.value = this.value.replace(/([\d]{3})([\d]{3})([\d]{3})([\d]{2})/, '$1.$2.$3-$4');
    }
});

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
        rule: (...value) => !/^[a-zA-Z\s\-]+$/.test(value[0]),
        message: 'o campo deve conter apenas letras e espaços.'
    },
    numeric: {
        rule: (...value) => !/^[0-9\.\,\-]+$/.test(value[0]),
        message: 'o campo deve conter apenas números.'
    },
    alphanumeric: {
        rule: (...value) => !/^[0-9a-zA-Z\s\.\,\-]+$/.test(value[0]),
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
    cpf: {
        rule: (...value) => !validateCpf(value[0]),
        message: 'cpf inválido'
    }
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

function validateCpf(strCPF) {
    strCPF = strCPF.replace(/(\.|\-)/g, '');

    let Soma;
    let Resto;
    Soma = 0;
  if (strCPF == "00000000000") return false;

  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
  Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

  Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}