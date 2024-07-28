(function ($) {
    "use strict";

    window.postResponse = function (response) {
        if (response.status === true) {
            $('#post-form')[0].reset();
            $(document).find('.error-message').remove();
            $(document).find("#files-names").html('');
            dt.clearData();
            $(document).find("#mAttachment1").trigger('change');
            toastr.success(response.message);
            loadMorePageCount = 0;
            loadMoreAjax($('#more-post-route').val(), loadMorePageCount, 1);
        } else {
            if (response.status === 422) {
                var errors = response.responseJSON.errors;
                $(document).find('.error-message').remove();
                $.each(errors, function (index, items) {
                    $('#post-form').find(':input[name=body]').closest('div').append('<span class="text-danger p-2 fs-12 z-index-10 position-relative error-message">' + items[0] + '</span>')
                });
            } else {
                toastr.error(response.message);
            }
        }
    };

    window.postUpdateResponse = function (response) {
        if (response.status === true) {
            toastr.success(response.message);
            if ($('.modal.show').length) {
                $('.modal.show').modal('toggle');
            }
            loadPostBody(response.data.slug);
        } else {
            if (response.status === 422) {
                var errors = response.responseJSON.errors;
                $(document).find('.error-message').remove();
                $.each(errors, function (index, items) {
                    $('#post-edit-form').find(':input[name=body]').closest('div').append('<span class="text-danger p-2 fs-12 z-index-10 position-relative error-message">' + items[0] + '</span>')
                });
            } else {
                toastr.error(response.message);
            }
        }
    };


    window.loadMoreAjax = function (url, page, reload) {
        postAjaxCalled = 1;
        $.ajax({
            type: "GET",
            url: url,
            data: {
                'page': page,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            datatype: "json",
            success: function (res) {
                loadMorePageCount++;
                postAjaxCalled = 0;
                const regex = /[' ']+#+([a-zA-Z0-9_#]+)/ig;
                var postData = res.data.html;
                var formatedPostData = postData.replace(regex, value => '<span class="text-primary fw-bold">'+value+'</span>');
                if (typeof reload != 'undefined' && reload == 1) {
                   $('#post-block').html(formatedPostData);
                } else {
                    $('#post-block').append(formatedPostData);
                }
                $(".gallery").each(function () {
                    $(this).magnificPopup({
                        delegate: "a",
                        type: "image",
                        showCloseBtn: false,
                        preloader: false,
                        gallery: {
                            enabled: true,
                        },
                        callbacks: {
                            elementParse: function (item) {
                                if (item.el[0].className == "video") {
                                    item.type = "iframe";
                                } else {
                                    item.type = "image";
                                }
                            },
                        },
                    });
                });
            }
        });
    };

    window.addEventListener('load', function () {
        loadMoreAjax($('#more-post-route').val(), loadMorePageCount);
    });


    window.loadPostBody = function(slug){
        let route = $('#load-post-body').val()+'?slug='+slug
        $.ajax({
            type: 'GET',
            url: route,
            success: function (response) {
                if(response.status == true){
                    $(document).find('.post-main-body-'+slug).replaceWith(response.data.html);
                    $(".gallery").each(function () {
                        $(this).magnificPopup({
                            delegate: "a",
                            type: "image",
                            showCloseBtn: false,
                            preloader: false,
                            gallery: {
                                enabled: true,
                            },
                            callbacks: {
                                elementParse: function (item) {
                                    if (item.el[0].className == "video") {
                                        item.type = "iframe";
                                    } else {
                                        item.type = "image";
                                    }
                                },
                            },
                        });
                    });
                }
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        })

    };


    $(document).on('click', '.edit-post-btn', function(){
        let selector = $(this);
        let slug = $(selector).closest('.post-main-area').find('.post-slug').val();
        let route = $('#post-edit').val()+'?slug='+slug

        $.ajax({
            type: 'GET',
            url: route,
            success: function (response) {
                if(response.status == true){
                    $(document).find("#files-names2").html('');
                    dt.clearData();
                    $('#post-edit-modal-content').html(response.data.html);
                    $('#postEditModal').modal('toggle');
                    $(document).find("#mAttachment3").trigger('change');
                }
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        })

    });
    $(document).on('click', '.delete-post-btn', function() {
        var selector = $(this);
        var slug = $(selector).closest('.post-main-area').find('.post-slug').val();
        var targetUrl = $('#delete-post-route').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Sure! You want to delete this?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete It!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'GET',
                    url: targetUrl,
                    data: {
                        slug: slug,
                        _token: csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $(selector).closest('.post-main-area').remove();
                            setTimeout(function() {
                                window.location.href = '/'; // Redirect to home after showing success message
                            }, 2000); // Adjust the timeout as needed
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            }
        });
    });


    window.loadMorePageCount = 1;
    window.postAjaxCalled = 0;

    $('body').on('scroll', function () {
        console.log($(this)[0].scrollHeight);
        if ($(this).scrollTop() + $(this).innerHeight() <= $(this)[0].scrollHeight) {
            if (postAjaxCalled == 0) {
                loadMoreAjax($('#more-post-route').val(), loadMorePageCount);
            }
        }
    });

})(jQuery)


