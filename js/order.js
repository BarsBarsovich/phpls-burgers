$('#order-form').on('submit', () => {
    event.preventDefault();
    console.log('Submitted');
    $.post('../php/form.php', $('#order-form').serialize())
        .done(() => {
            alert('Your order complete');
        })
        .fail(() => {
            alert('Error');
        })
})