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

    window.postCommentUpdateResponse = function (response) {
        toastr.success(response.message);
        if (response.status === true) {
            loadComment(response.data.post_slug);
            if ($('.modal.show').length) {
                $('.modal.show').modal('toggle');
            }
        }
    }

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

    window.loadComment = function(slug){
        let route = $('#load-comments').val()+'?slug='+slug
        $.ajax({
            type: 'GET',
            url: route,
            success: function (response) {
                if(response.status == true){
                const regex = /[' ']+#+([a-zA-Z0-9_#]+)/ig;
                var commentBoxHtmlData = response.data.comment_box_html;
                var formatCommentBoxHtmlData = commentBoxHtmlData.replace(regex, value => '<span class="text-primary fw-bold">'+value+'</span>');
                    $(document).find('.like-comment-area-'+slug).find('.post-comment-button').html(response.data.comment_button_html);
                    $(document).find('.like-comment-area-'+slug).find('.post-comment-area').html(formatCommentBoxHtmlData);
                }
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        })

    };

    window.loadLike = function(slug){
        let route = $('#load-likes').val()+'?slug='+slug
        $.ajax({
            type: 'GET',
            url: route,
            success: function (response) {
                if(response.status == true){
                    $(document).find('.postLike-'+slug).replaceWith(response.data.html);
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

    $(document).on('click', '.postLike', function(){
        let selector = $(this);
        let slug = $(selector).closest('.post-main-area').find('.post-slug').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        let route = $('#post-like-route').val();
        $.ajax({
            type: 'POST',
            url: route,
            data: {'slug':slug,'_token':csrfToken},
            success: function (response) {
                toastr.success(response.message);

                if(response.status == true){
                    loadLike(slug, selector);
                }
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        })

    });

    $(document).on('click', '.delete-post-btn', function(){
        var selector = $(this);
        var slug =  $(selector).closest('.post-main-area').find('.post-slug').val();
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
                    type: 'DELETE',
                    url: targetUrl,
                    data: {'slug':slug,'_token':csrfToken},
                    success: function (response) {
                        toastr.success(response.message);

                        if(response.status == true){
                            $(selector).closest('.post-main-area').remove();
                        }
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message)
                    }
                })
            }
        })
    });

    window.loadMorePageCount = 1;
    window.postAjaxCalled = 0;

    $('body').on('scroll', function () {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            if (postAjaxCalled == 0) {
                loadMoreAjax($('#more-post-route').val(), loadMorePageCount);
            }
        }
    });

    $(document).on('keyup', '.postCommentInput', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            let selector = $(this);
            let replyToId = null;
            if(!($(selector).closest('.comment-input-box').find('.reply-note').hasClass('d-none'))){
                replyToId = $(selector).closest('.comment-input-box').find('.reply-note').find('.reply-to-id-input').val();
            }

            let slug = $(selector).closest('.post-main-area').find('.post-slug').val();
            let body = $(this).val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            let route = $('#post-comment-store').val();
            $.ajax({
                type: 'POST',
                url: route,
                data: {'slug':slug, 'body': body, 'parent_id' : replyToId,  '_token':csrfToken},
                success: function (response) {
                    toastr.success(response.message);
                    if(response.status == true){
                        $(document).find(selector).closest('.comment-input-box').find('.reply-note').addClass('d-none');
                        $(document).find(selector).closest('.comment-input-box').find('.reply-note').find('.reply-to-id-input').val('');
                        $(document).find(selector).closest('.comment-input-box').find('.reply-note').find('.reply-to-name').html('');
                        $(document).find(selector).val('');

                        loadComment(slug);
                    }
                },
                error: function (error) {
                    toastr.error(error.responseJSON.message)
                }
            })
        }
    });

    $(document).on('click', '.comment-delete', function (e) {
        let selector = $(this);
        let id = $(selector).data('id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        let route = $('#post-comment-delete').val();
        $.ajax({
            type: 'DELETE',
            url: route,
            data: {'id':id, '_token':csrfToken},
            success: function (response) {
                toastr.success(response.message);
                if(response.status == true){
                    $(selector).closest('.single-comment-block').remove();
                }
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        })
    });

    $(document).on('click', '.reply-btn', function (e) {
        $(this).closest('.like-comment-area').find('.reply-to-name').text('');
        $(this).closest('.like-comment-area').find('.reply-note').find('.reply-to-id-input').val('');
        $(this).closest('.like-comment-area').find('.postCommentInput').val('');

        $(this).closest('.like-comment-area').find('.reply-note').removeClass('d-none');

        $(this).closest('.like-comment-area').find('.reply-to-name').text($(this).closest('.comment-data').data('user-name'));
        $(this).closest('.like-comment-area').find('.reply-note').find('.reply-to-id-input').val($(this).closest('.comment-data').data('id'));

        $('body').animate({
            scrollTop: ($(this).closest('.like-comment-area').find('.postCommentInput')[0]).top
         }, 1000);

        if ($(this).closest('.like-comment-area').find('.postCommentInput')) $($(this).closest('.like-comment-area').find('.postCommentInput')).focus();
    });

    $(document).on('click', '.cancel-reply-to', function (e) {
        $(this).closest('.reply-note').addClass('d-none');
        $(this).closest('.reply-note').find('.reply-to-id-input').val('');
        $(this).closest('.reply-note').find('.reply-to-name').html('');
        $(this).closest('.comment-input-box').find('.postCommentInput').val('');
    });

    $(document).on('click', '.comment-edit', function(){
        let selector = $(this);
        let id = $(selector).data('id');
        let body = $(selector).data('comment-body');

        $('#comment-edit-modal-content').find(':input[name=id]').val(id);
        $('#comment-edit-modal-content').find(':input[name=body]').val(body);
        $('#commentEditModal').modal('toggle');

    });

    $(document).on('click', '.comment-update', function(){
        let selector = $(this);
        let id = $(selector).data('id');
        let body = $(selector).data('comment-body');
        let route = $('#post-comment-update').val();

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'PUT',
            url: route,
            data: {'id':id, 'body' : body, '_token':csrfToken},
            success: function (response) {
                if(response.status == true){
                    $('#comment-edit-modal-content').html(response.data.html);
                    $('#commentEditModal').modal('toggle');
                }
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        })
    });

})(jQuery)


