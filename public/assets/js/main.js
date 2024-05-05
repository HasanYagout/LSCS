(function ($) {
    "use strict";

    /*-------------------------------------------
    Sticky Header
    --------------------------------------------- */
    var lastScroll = 0;
    var isScrolled = false;
    window.dt = new DataTransfer();

    window.addEventListener("scroll", function () {
        var header = document.querySelector(".header-area");
        if (header) {
            var currentScroll = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            var scrollDirection = currentScroll < lastScroll;
            var shouldToggle = isScrolled && scrollDirection;

            if (currentScroll === 0) {
                header.classList.remove("stick");
            } else {
                isScrolled = true;
                header.classList.toggle("stick", shouldToggle);
            }

            lastScroll = currentScroll;
        }
    });

    jQuery(document).ready(function () {
        /*-------------------------------------------
        js scrollup
        --------------------------------------------- */
        $.scrollUp({
            scrollText: '<i class="fa fa-angle-up"></i>',
            easingType: "linear",
            scrollSpeed: 900,
            animation: "fade",
        });
    });

    var Medi = {
        init: function () {
            this.Basic.init();
        },

        Basic: {
            init: function () {
                this.Preloader();
                this.Tools();
                this.BackgroundImage();
                this.MobileMenu();
                this.EventPayMent();
                this.Select();
                this.Editor();
                this.DateRangePicker();
                this.Message();
                this.FilUpLoad();
                this.PriceSlide();
            },
            Preloader: function () {
                $("#preloader-status").fadeOut();
                $("#preloader").delay(350).fadeOut("slow");
                $("body").delay(350);
            },
            Tools: function () {
                $("input.date-time-picker").each(function () {
                    $(this).closest(".primary-form-group-wrap").addClass("calendarIcon"); // Add your custom class here
                });
            },
            PriceSlide: function () {
                var swiper2 = new Swiper(".ld-price-plan-wrap", {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 24,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 24,
                        },
                    },
                });
            },
            BackgroundImage: function () {
                $("[data-background]").each(function () {
                    $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
                });
            },
            MobileMenu: function () {
                $(".mobileMenu").on("click", function () {
                    $(".zSidebar").addClass("menuClose");
                });
                $(".zSidebar-overlay").on("click", function () {
                    $(".zSidebar").removeClass("menuClose");
                });
                // Menu arrow
                $(".zSidebar-menu li a").each(function () {
                    if ($(this).next("div").find("ul.zSidebar-submenu li").length > 0) {
                        $(this).addClass("has-subMenu-arrow");
                    }
                });
            },
            EventPayMent: function () {
                $(document).on("click", ".paymentItem", function () {
                    $(this).closest('ul').find(".paymentItem-input").prop("checked", false);
                    $(this).find(".paymentItem-input").prop("checked", true);
                });
            },
            Select: function () {
                // when need select with search field
                $(".sf-select").select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                    // minimumResultsForSearch: -1,
                });
                // when don't need search field but can't use in modal
                $(".sf-select-two").select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                    minimumResultsForSearch: -1,
                });
                // when don't need search field and can use in modal
                $(".sf-select-without-search").niceSelect();
                // when need search in modal
                $(".sf-select-modal").select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                    dropdownParent: $(".modal"),
                });
            },
            Editor: function () {
                $(".summernoteOne").summernote({
                    placeholder: "Write description...",
                    tabsize: 2,
                    minHeight: 183,
                    toolbar: [
                        ["font", ["bold", "italic", "underline"]],
                        ["para", ["ul", "ol", "paragraph"]],
                    ],
                });
            },
            DateRangePicker: function () {
                $(".date-time-picker").daterangepicker({
                    singleDatePicker: true,
                    timePicker: true,
                    locale: {
                        format: "Y-M-D h:mm",
                    },
                });
            },
            Message: function () {
                // For Message
                const userChats = document.querySelectorAll(".user-chat");
                const chatMessages = document.querySelectorAll(".content-chat-message-user");

                userChats.forEach((userChat) => {
                    userChat.addEventListener("click", () => {
                        const selectedId = userChat.getAttribute("data-id");

                        chatMessages.forEach((chatMessage) => {
                            const messageId = chatMessage.getAttribute("data-id");

                            if (messageId === selectedId) {
                                chatMessage.classList.add("active");
                            } else {
                                chatMessage.classList.remove("active");
                            }
                        });

                        userChats.forEach((chat) => {
                            chat.classList.remove("active");
                        });
                        userChat.classList.add("active");
                        loadMorePageCount = 0;
                        loadSingleUserChat($('#single-user-chat-route').val(), loadMorePageCount, 0, 1);
                    });

                    // Activate the first user-chat element initially
                    // userChats[0].classList.add("active");
                    // chatMessages[0].classList.add("active");
                });
            },
            FilUpLoad: function () {
                // File attachment

                $("#mAttachment,#mAttachment1").on("change", function (e) {
                    for (var i = 0; i < this.files.length; i++) {
                        let fileBloc = $("<span/>", {class: "file-block"}),
                            fileName = $("<p/>", {class: "name", text: this.files.item(i).name});
                        fileBloc.append('<span class="file-icon"><i class="fa-solid fa-file"></i></span>').append(fileName).append('<span class="file-delete"><i class="fa-solid fa-xmark"></i></span>');
                        $(document).find("#filesList > #files-names").append(fileBloc);
                    }

                    for (let file of this.files) {
                        dt.items.add(file);
                    }

                    this.files = dt.files;

                    $(document).on("click", "span.file-delete", function () {
                        let name = $(this).closest('.file-block').find('.name').text();

                        $(this).parent().remove();
                        for (let i = 0; i < dt.items.length; i++) {
                            if (name === dt.items[i].getAsFile().name) {
                                dt.items.remove(i);
                                continue;
                            }
                        }

                        this.files = dt.files;
                    });
                });

                $(document).on('change', "#mAttachment3", function (e) {

                    for (var i = 0; i < this.files.length; i++) {
                        let fileBloc = $("<span/>", {class: "file-block"}),
                            fileName = $("<p/>", {class: "name", text: this.files.item(i).name});
                        fileBloc.append('<span class="file-icon"><i class="fa-solid fa-file"></i></span>').append(fileName).append('<span class="file-delete"><i class="fa-solid fa-xmark"></i></span>');
                        $(document).find("#filesList2 > #files-names2").append(fileBloc);
                    }

                    for (let file of this.files) {
                        dt.items.add(file);
                    }

                    this.files = dt.files;

                    $(document).on('click', "span.file-delete", function () {
                        let name = $(this).closest('.file-block').find('.name').text();

                        $(this).parent().remove();
                        for (let i = 0; i < dt.items.length; i++) {
                            if (name === dt.items[i].getAsFile().name) {
                                dt.items.remove(i);
                                continue;
                            }
                        }

                        this.files = dt.files;
                    });
                });
            },
        },
    };
    jQuery(document).ready(function () {
        Medi.init();
    });
})(jQuery);
