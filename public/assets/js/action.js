$(document).on('submit', 'form', function (e) {
    e.preventDefault();

    $(this).find('.form-control').removeClass('is-invalid');
    $('.alert').remove();
    $('.error-message').remove();
    $('#errorAccordion').remove();

    let button = $(this).find('button[type="submit"]');
    let buttonText = button.text();
    button.prop('disabled', true);
    button.html(`<span class="button-spinner spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);

    let formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method') || 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status) {
                $(e.target).before(`
                    <div class="mb-3 text-white alert alert-success alert-dismissible bg-success alert-label-icon fade show material-shadow" role="alert">
                        <i class="ri-check-line label-icon"></i><strong>Success!</strong> - ${response.message}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);

                const modal = $(e.target).closest('.modal');
                if (modal.length > 0) {
                    modal.modal('hide');
                }
            }

            if (response.redirect_url) {
                if ($.fn.DataTable) {
                    $('.dataTable').each(function () {
                        if ($.fn.DataTable.isDataTable(this)) {
                            $(this).DataTable().destroy();
                        }
                    });
                }
            
                window.location.href = response.redirect_url;
            }

            if ($.fn.DataTable) {
                $('.dataTable').each(function () {
                    if ($.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable().ajax.reload(null, false);
                    }
                });
            }

            if (!$(e.target).attr('id')?.endsWith('_update')) {
                if ($(e.target).data('reset') !== false) {
                    $(e.target).trigger('reset');
                }

                if ($(e.target).data('reload')) {
                    location.reload();
                }

                if ($.fn.select2) {
                    $('.select2').each(function () {
                        $(this).val(null).trigger('change');
                    });
                }
            }

            $.each($(e.target).data(), function (key, value) {
                if (typeof window[value] === 'function') {
                    try {
                        window[value]();
                    } catch (err) {
                        console.error(`Error when calling data-${key}:`, err);
                    }
                }
            });

            if (response.data && response.data.length > 0) {
                if ($(e.target).data('import')) {
                    let alertMessage = `  
                        <div class="accordion custom-accordionwithicon accordion-fill-danger mb-3" id="errorAccordion">  
                            <div class="accordion-item">  
                                <h2 class="accordion-header" id="headingOne">  
                                    <button class="accordion-button bg-danger text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseErrors" aria-expanded="true" aria-controls="collapseErrors">  
                                        Oops! - The following errors occurred  
                                    </button>  
                                </h2>  
                                <div id="collapseErrors" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#errorAccordion">  
                                    <div class="accordion-body p-0 m-0">  
                                        <table class="table table-danger">  
                                            <thead>  
                                                <tr>  
                                                    <th scope="col">Row</th>  
                                                    <th scope="col">Attribute</th>  
                                                    <th scope="col">Error</th>  
                                                    <th scope="col">Value</th>  
                                                </tr>  
                                            </thead>  
                                            <tbody>  
                    `;  
                
                    $.each(response.data, function(index, error) {  
                        alertMessage += `  
                            <tr>  
                                <td>${error.row}</td>  
                                <td>${error.attribute}</td>  
                                <td>${error.errors.join(", ")}</td>  
                                <td>${error.values[error.attribute]}</td>
                            </tr>  
                        `;  
                    });  
                    
                    alertMessage += `  
                                            </tbody>  
                                        </table>  
                                    </div>  
                                </div>  
                            </div>  
                        </div>  
                    `;  
                
                    $(e.target).before(alertMessage);  
                }  
            }
        },
        error: function (xhr) {
            let response = xhr.responseJSON;
            let errors = response.errors;

            if ('status' in response) {
                if (response.errors) {  
                    $(e.target).before(`  
                        <div class="mb-3 text-white alert alert-danger alert-dismissible bg-danger alert-label-icon fade show material-shadow" role="alert">  
                            <i class="ri-error-warning-line label-icon"></i><strong>Oops!</strong> - ${response.errors}  
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>  
                        </div>  
                    `);  
                } else if (response.message) {  
                    $(e.target).before(`  
                        <div class="mb-3 text-white alert alert-danger alert-dismissible bg-danger alert-label-icon fade show material-shadow" role="alert">  
                            <i class="ri-error-warning-line label-icon"></i><strong>Oops!</strong> - ${response.message}  
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>  
                        </div>  
                    `);  
                }  
            } else {
                if ('errors' in response) {
                    $.each(errors, function(field, message) {
                        let inputName = field.replace(/\.(\d+)/g, '[$1]');
                        inputName = inputName.replace(/\./g, '\\.').replace(/\[/g, '\\[').replace(/\]/g, '\\]');
                        let input = $(`[name="${inputName}"]`);
    
                        input.addClass('is-invalid');
    
                        input.after(`
                            <div class="error-message text-danger mt-1">${message[0]}</div>
                        `);
                    });
                } else {
                    $(e.target).before(`
                        <div class="mb-3 text-white alert alert-danger alert-dismissible bg-danger alert-label-icon fade show material-shadow" role="alert">
                            <i class="ri-error-warning-line label-icon"></i><strong>Oops!</strong> - ${response.message}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            }
        },
        complete: function () {
            button.prop('disabled', false);
            button.text(buttonText);
        }
    });
});