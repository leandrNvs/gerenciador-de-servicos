const form = document.querySelector('form');

const validation = {
    'numeric': /^[0-9\s]+$/,
    'letter': /^[a-zA-Z\s]+$/,
    'required': /^.+$/,
    'alphanumeric': /^[\w\d\s]+$/
}

const errors = {
    'numeric': 'O campo deve conter apenas números',
    'letter': 'O campo deve conter apenas letras',
    'required': 'O preenchimento do campo é obrigatório',
    'alphanumeric': 'O campo deve conter letras e números'
}

const fields = { 
    name: 'required|letter',
    contact: 'required|number',
    cpf: 'required|numer',
    address: 'required|alphanumeric'
};

function contactMask(input) {

}

function cpfMask(input) {

}

function applyTest(field, test) {
    const tests = test.split('|');

    let res = null;

    tests.forEach((test) => {
        if(!test.test(field)) {
            res = errors[test];
        }
    });

    return res;
}

form.addEventListener('submit', function(e) {
    e.preventDefault();

    applyTest(name, fields[name])
});
