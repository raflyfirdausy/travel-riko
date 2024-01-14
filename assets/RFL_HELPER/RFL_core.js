const validateNumberOnly = (element) => element.value = element.value.replace(/[^0-9]/, '')

const generateDatatable = (tableId, url, columns) => {
    return $(`#${tableId}`).DataTable({
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Oops, data tidak ditemukan",
            "infoFiltered": "(di filter dari _MAX_ total data)",
            "loadingRecords": "Loading...",
            "processing": "Sedang mengambil data...",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            },
            'select': {
                'rows': {
                    '_': '%d rows selected',
                    '0': '',
                    '1': '%d row selected'
                }
            }
        },
        'columnDefs': [{
            'targets': 0,
            'checkboxes': {
                'selectRow': true,
            }
        }],
        'select': {
            'style': 'multi',
            'selector': 'td:not(:first-child)'
        },
        'order': [
            [1, 'asc']
        ],
        "responsive": true,
        "bFilter": false,
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "searching": true,
        "ordering": false,
        "columns": columns,
        "ajax": {
            "url": `${url}`,
            "type": "POST"
        },
    })
}

const generateDatatableBackup = (tableId, url, columns) => {
    return $(`#${tableId}`).DataTable({
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Oops, data tidak ditemukan",
            "infoFiltered": "(di filter dari _MAX_ total data)",
            "loadingRecords": "Loading...",
            "processing": "Sedang mengambil data...",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            },
        },
        "sDom": 'lrtip',
        "bFilter": false,
        "bInfo": false,
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "searching": true,
        "ordering": false,
        "columns": columns,
        "ajax": {
            "url": `${url}`,
            "type": "POST"
        },

    })
}


const generateSearchTable = (tableId, dataTable, hideSearch) => {
    // console.log({hideSearch})
    $(`#${tableId} thead tr`).clone(true).appendTo(`#${tableId} thead`);
    $(`#${tableId} thead tr:eq(1) th`).each(function (i) {
        var title = $(this).text();
        if (hideSearch.includes(i)) {
            $(this).html('');
        } else {
            $(this).html(`<input class="form-control" style="width: 100%" type="text" placeholder="Cari ${title}" />`);
        }

        var typingTimer
        var doneTypingInterval = 500

        function search(valueText) {
            if (dataTable.column(i).search() !== valueText) {
                dataTable.column(i).search(valueText).draw();
            }
        }

        $('input', this).on('keyup', function (e) {
            clearTimeout(typingTimer)
            let valueText = this.value
            typingTimer = setTimeout(() => search(valueText), doneTypingInterval)
        })

        $('input', this).on('keydown', function (e) {
            clearTimeout(typingTimer)
        })
    })
}

const generateAjaxProses = (formId, url, dataTable) => {
    $(`#${formId}`).submit(e => {
        e.preventDefault()
        var form = $(`#${formId}`)[0]
        var data = new FormData(form)

        $(".proses_btn").prop('disabled', true)
        $(".proses_btn").text("Sedang menyimpan data...")

        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            text: 'Sedang menyimpan data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (result) {
                        $(".proses_btn").prop('disabled', false)
                        $(".proses_btn").text("Simpan")
                        if (result.code == 200) {
                            dataTable.ajax.reload(null, false)
                            Swal.fire({
                                title: 'Sukses',
                                text: result.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            }).then((result) => {
                                $(`#${formId}`).trigger("reset");
                                $(".modal").modal("hide")
                            })
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                html: result.message,
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            })
                        }

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $(".proses_btn").prop('disabled', false)
                        $(".proses_btn").text("Simpan")
                        Swal.fire({
                            title: 'Gagal',
                            text: xhr.responseText,
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tutup'
                        })
                    }
                })
            }
        })
    })
}

const generateAddSelectAjax = () => {
    let formId = "form_add_select"
    let modalId = "modal_add_select"
    $(`#${formId}`).submit(e => {
        e.preventDefault()
        var url = $(`#${formId}`).attr('action')
        var form = $(`#${formId}`)[0]
        var data = new FormData(form)

        $(".proses_btn_select").prop('disabled', true)
        $(".proses_btn_select").text("Sedang menyimpan data...")

        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            text: 'Sedang menyimpan data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (result) {
                        $(".proses_btn_select").prop('disabled', false)
                        $(".proses_btn_select").text("Simpan")
                        if (result.code == 200) {
                            Swal.fire({
                                title: 'Sukses',
                                text: result.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            }).then((result) => {
                                $(`#${formId}`).trigger("reset");
                                $(`#${modalId}`).modal("hide")
                            })
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                html: result.message,
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            })
                        }

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $(".proses_btn_select").prop('disabled', false)
                        $(".proses_btn_select").text("Simpan")
                        Swal.fire({
                            title: 'Gagal',
                            text: xhr.responseText,
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tutup'
                        })
                    }
                })
            }
        })

    })
}

const hapusData = (dataId, url, dataTable) => {
    swal.fire({
        title: 'Peringatan',
        text: "Apakah anda yakin ingin menghapus data ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Hapus'
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: 'Mohon Tunggu Beberapa Saat',
                text: 'Sedang menghapus data...',
                didOpen: () => {
                    Swal.showLoading()
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            "id_data": dataId
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.code == 200) {
                                Swal.fire({
                                    title: 'Terhapus',
                                    text: data.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Tutup'
                                }).then((result) => {
                                    dataTable.ajax.reload(null, false)
                                })
                            } else {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: data.message,
                                    icon: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Tutup'
                                })
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            Swal.fire({
                                title: 'Gagal',
                                text: xhr.responseText,
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            })
                        }
                    })
                }
            })
        }
    })
}

const modalEditAction = (id, url, modalId, fieldForm) => {
    Swal.fire({
        title: 'Mohon Tunggu Beberapa Saat',
        text: 'Sedang mengambil data...',
        didOpen: () => {
            Swal.showLoading()
            $.ajax({
                url: url + id,
                type: "GET",
                dataType: "JSON",
                contentType: "application/json; charset=utf-8",
                success: function (result) {
                    Swal.close()
                    if (result.code == 200) {
                        let data = result.data
                        fieldForm.forEach((currentValue, index, arr) => {
                            // console.log({currentValue, data})
                            if (currentValue.type != "file" && currentValue.type != "password") {
                                if (currentValue.type == "select") {
                                    if (currentValue.options.chain) {
                                        $(`#${currentValue.name}_edit`).html(`<option value="${data[currentValue.name]}" selected>${data[currentValue.name_alias]}</option>`)
                                        // $(`#${currentValue.name}_edit`).val(data[currentValue.name]).trigger("change")
                                    } else {
                                        $(`#${currentValue.name}_edit`).val(data[currentValue.name]).trigger("change")
                                    }
                                } else {
                                    $(`#${currentValue.name}_edit`).val(data[currentValue.name])
                                }
                            }
                        })
                        $("#id_data").val(data.uuid)
                        $(`#${modalId}`).modal("show")
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            text: result.message,
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tutup'
                        })
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        title: 'Gagal',
                        text: xhr.responseText,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Tutup'
                    })
                }
            })
        }
    })
}

const generateSelect2ServerSide = (element, url, placeholder) => {
    element.select2({
        theme: 'bootstrap-5',
        placeholder: (typeof placeholder !== undefined) ? placeholder : "Pilih data",
        width: '100%',
        escapeMarkup: markup => {
            return markup
        },
        templateResult: data => {
            return (typeof data.html !== undefined) ? data.html : data.text
        },
        templateSelection: data => {
            return (typeof data.html !== undefined) ? data.html : data.text
        },
        ajax: {
            url: url,
            delay: 250,
            cache: true,
            minimumInputLength: 1,
            data: (params) => {
                var query = {
                    search: params.term,
                    page: params.page || 1,
                    perpage: params.perpage || 50
                }
                return query;
            },
            processResults: (data, params) => {
                let result = JSON.parse(data)
                return {
                    results: result.data.items,
                    pagination: {
                        more: result.data.paging.page < result.data.paging.total_page
                    }
                };
            },
        }
    })
}

const generateSelect2InModalServerSide = (idOrClass, url, placeholder) => {
    $('.modal').on('shown.bs.modal', function (e) {
        $(this).find(idOrClass).select2({
            width: '100%',
            theme: 'bootstrap-5',
            dropdownParent: $(this).find('.modal-content'),
            placeholder: (typeof placeholder !== undefined) ? placeholder : "Pilih data",
            language: {
                searching: () => {
                    return "Tunggu beberapa saat...";
                }
            },
            ajax: {
                url: url + "/get-select",
                delay: 250,
                cache: true,
                minimumInputLength: 1,
                data: (params) => {
                    var query = {
                        search: params.term,
                        page: params.page || 1,
                        perpage: params.perpage || 50
                    }
                    return query;
                },
                processResults: (data, params) => {
                    let result = JSON.parse(data)
                    return {
                        results: result.data.items,
                        pagination: {
                            more: result.data.paging.page < result.data.paging.total_page
                        }
                    };
                },
            }
        });
    })
}

const showModalAddSelect = (url) => {
    Swal.fire({
        title: 'Mohon Tunggu Beberapa Saat',
        text: 'Sedang mengambil data...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
            $.ajax({
                type: "GET",
                dataType: "JSON",
                contentType: "application/json; charset=utf-8",
                url: url,
                processData: false,
                contentType: false,
                cache: false,
                success: function (result) {
                    Swal.close()
                    if (result.code == 200) {
                        $("#section_modal_select").html(result.data)
                        $('#modal_add_select').modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });

                        $("#modal_add_select").modal("show");
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            html: result.message,
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tutup'
                        })
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        title: 'Gagal',
                        text: xhr.responseText,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Tutup'
                    })
                }
            })
        }
    })
}

const showModalIframe = (title, url, isImage) => {    
    if (typeof isImage !== undefined && isImage == "YA") {
        $("#contentIframe").hide()
        $("#imgIframe").attr('src', url)
        $("#imgIframe").show()
    } else {
        $("#imgIframe").hide()
        $("#contentIframe").attr('src', url)
        $("#contentIframe").show()
    }

    $("#titleIframe").text(title)

    $("#modal_iframe").modal("show")
}