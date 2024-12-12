const form = document.querySelector('form');

form.client_cpf?.addEventListener('keyup', function() {
    if(this.value.length === 11) {
        this.value = this.value.replace(/([\d]{3})([\d]{3})([\d]{3})([\d]{2})/, '$1.$2.$3-$4');
    }
});

form.client_cpf?.addEventListener('keydown', function(e) {
    if(this.value.length > 11 && e.key.toLowerCase() !== 'backspace') {
        e.preventDefault();
    }
});

form.client_phone?.addEventListener('keyup', function(e) {
    if(this.value.length === 11) {
        this.value = this.value.replace(/([\d]{2})([\d]{5})([\d]{4})/, '($1) $2-$3');
    }
});

form.client_phone?.addEventListener('keydown', function(e) {
    if(this.value.length > 11 && e.key.toLowerCase() !== 'backspace') {
        e.preventDefault();
    }
});

form.car_year?.addEventListener('keydown', function(e) {
    if(this.value.length > 3 && e.key.toLowerCase() !== 'backspace') {
        e.preventDefault();
    }
});


const formServiceInfo = document.querySelector('form.form-serviceinfo');

function updateInfo(url, data)
{
    const d = JSON.parse(data);

    formServiceInfo.action = url;

    formServiceInfo.service_detail.value = d.detail;
    formServiceInfo.service_price.value =  d.price;
    formServiceInfo.service_descount.value = d.descount;

    formServiceInfo.querySelector('.form-buttons button').textContent = 'Salvar alterações';
    formServiceInfo.querySelector('.form-buttons a').href = window.location.href;
}

const formPart = document.querySelector('form.form-part');

function updatePart(url, data)
{
    const d = JSON.parse(data);

    formPart.action = url;

    formPart.part_seller.value = d.seller;
    formPart.part_place.value =  d.place;
    formPart.part_date_purchase.value = d.date;
    formPart.part_price.value = d.price;
    formPart.part_quantity.value = d.quantity;
    formPart.part_name.value = d.name;

    formPart.querySelector('.form-buttons button').textContent = 'Salvar alterações';
    formPart.querySelector('.form-buttons a').href = window.location.href;
}