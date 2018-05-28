var cl = console.log.bind(console);
cl("js online");

//today date in input

//
$("input[type='button']").click(function(e) {
    e.preventDefault();
    cl($(this).val());
    switch ($(this).val()) {
        case 'Add':
            (async() => {
                const {
                    value: formValues
                } = await swal({
                    title: 'Insert new Employee details',
                    html: '<input type="number" id="id" class="swal2-input">' +
                        '<input type="text" id="name" class="swal2-input">' +
                        '<input type="date" id="date" class="swal2-input" value="' + formatDate(new Date()) + '" >',
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            document.getElementById('id').value,
                            document.getElementById('name').value,
                            document.getElementById('date').value
                        ]
                    }
                })
                if (formValues) {
                    // swal(JSON.stringify(formValues))
                    $.ajax({
                            type: "POST",
                            url: "workerCRUD.php",
                            data: {
                                id: formValues[0],
                                name: formValues[1],
                                recruitment_date: formValues[2],
                            },
                            success: function(data) {

                            }
                        })
                        .done(function(data) {
                            //cl('success', data)
                            data = JSON.parse(data);
                            // cl(data);
                            if (data.error) {
                                cl('error', data.error)
                                swal(
                                    'Error processing request!',
                                    JSON.stringify(data),
                                    'error'
                                )
                            }
                            if (data.success === true) {
                                cl('success', data)
                                swal(
                                    'Employee registered succesfully',
                                    JSON.stringify(data),
                                    'success'
                                )
                            }
                        })
                        .fail(function(xhr) {
                            console.log('error', xhr);
                        });
                }
            })();
            break;
        case 'Get':

            break;
        case 'Update':

            break;
        case 'Delete':

            break;
        case 'Get All':

            break;
    }
});

//date function
function formatDate(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    if (day < 10) {
        dd = '0' + dd
    }
    if (month < 10) {
        month = '0' + month
    }
    return year + '-' + month + '-' + day;
}