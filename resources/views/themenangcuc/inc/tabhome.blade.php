<div class="list-films film-new">
    <h2 id="myTabGroup" class="title-box">
        <a title="Phim bộ mới cập nhật" rel="nofollow" href="javascript:void(0)" data-id="1" class="tab active">Phim
            bộ mới</a>
        <a title="Phim lẻ mới cập nhật" rel="nofollow" href="javascript:void(0)" data-id="2" class="tab">Phim lẻ mới</a>
    </h2>
    <div class="tab-content1" data-id="1" style="display: block;">
        <ul class="film-moi tab-content">
            @foreach ($phimbomoi as $movie)
                @include('themes::thememotchill.inc.sections_movies_item')
            @endforeach
        </ul>
    </div>
    <div class="tab-content1" data-id="2" style="display: none;">
        <ul class="film-moi tab-content">
            @foreach ($phimlemoi as $movie)
                @include('themes::thememotchill.inc.sections_movies_item')
            @endforeach
        </ul>
    </div>
</div>
<style>
    .list-films {
        overflow: hidden;
    }

    @media (min-width: 250px) and (max-width: 979px) {
        .title-box {
            padding-left: 8px;
        }
    }

    .title-box {
        padding: 10px;
        font-family: Arial, Tahoma;
        font-size: 14px;
        color: #ff9601;
        font-weight: 300;
    }

    .title-box .tab.active,
    .title-box .tab:hover {
        color: #da966e;
    }

    .title-box .tab.active {
        color: rgb(229 231 235);
        padding-bottom: .25rem;
        padding-top: .25rem;
        padding-left: .75rem;
        padding-right: .75rem;
        background-color: rgb(163 118 93);
        font-weight: 500;
        text-transform: uppercase;
        border-radius: .125rem;
        
    }

    .title-box .tab {
        
        cursor: pointer;
        margin-right: 10px;
    }
</style>
<script>
    $(document).ready(function() {
        $("#myTabGroup .tab").click(function() {
            var tabId = $(this).data("id");
            $("#myTabGroup .tab").removeClass("active");
            $(this).addClass("active");
            $(".tab-content1").hide();
            $(".tab-content1[data-id=" + tabId + "]").show();
        });
    });
</script>
