function search_item() {
    var result_container = $('.search-dropdown-hot');
    var xhr = null;
    var inputTimer = null;
    var input = '';
    var search_item = function (str) {
        if (xhr) {
            xhr.abort();
        }
        xhr = $.ajax({
            type: 'GET',
            url: '/tim-kiem.html',
            dataType: 'html',
            data: {
                t: 'nav_search',
                q: str,
                num: 3
            },
            beforeSend: function () {
                result_container.empty();
            },
            success: function (msg) {
                result_container.html(msg).show();
            },
            error: function () {
                renderError('timeout', str);
            }
        });
    };
    var renderError = function (str, keyword) {
        if (str == 'no item found' || str == 'timeout') {
            var _str = '';
            _str += '<p class="nav_search_notif">Không tìm thấy kết quả trả về cho từ khóa <b>\'' + keyword + '\'</b></p>';
            result_container.html(_str).show();
        }
    };
    $('.search-box').find('input[name=q]').on('keyup', function () {
        clearTimeout(inputTimer);
        var input = $(this).val();
        if (input.length > 2) {
            inputTimer = setTimeout(function () {
                search_item(input);
            }, 100);
        } else {
            result_container.hide();
        }
    });
}
$(function () {
    if (!detectMob()) {
        $(document).mouseup(function (e) {
            var container = $(".search-box");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.find('.search-dropdown-hot').hide();
            }
        });
        search_item();
    }
});
$('.flickity').flickity({
    cellAlign: 'left',
    contain: true,
    draggable: true,
});
$('body').on('click', '.control.menu', function () {
    var __this = $(this);
    $('.menu-block').slideToggle('fast');
    $('.myui-header__search').hide();
}).on('click', '.control.search', function () {
    var __this = $(this);
    $('.myui-header__search').toggle();
    $('.menu-block').slideUp('fast');
}).on('click', '.schedule-tab .tab', function() {
    var __this = $(this);
    __this.parent().find('.tab').removeClass('active');
    __this.addClass('active');
    var tabId = $(this).attr('data-id');
    $.ajax({
        url: '/ajax/schedule',
        type: 'post',
        data: {id: tabId},
        success: function (data) {
            $('.schedule-block .myui-vodlist').html(data);
        }
    });
});
