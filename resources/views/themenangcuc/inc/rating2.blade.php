<div class="box-rating" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
    <div id="star" data-score="{{ $currentMovie->getRatingStar() }}" style="cursor: pointer;"></div>
    <div>
        <div id="div_average" style="line-height: 16px; margin: 0 5px; ">
            <span id="hint"></span>
            (<span class="average" id="average" itemprop="ratingValue">{{ $currentMovie->getRatingStar() }}</span>
                điểm /
            <span id="rate_count" itemprop="ratingCount">{{ $currentMovie->getRatingCount()}}</span> &nbsp;lượt)
        </div>
        <meta itemprop="bestRating" content="10" />
        <input id="film_id" type="hidden" value="{{ $currentMovie->id }}">
    </div>
</div>
<script src="/themes/nangcuc/rating2/jquery.raty.js"></script>
<script>
    var rated = false;
    $('#star').raty({
        number: 10,
        starHalf: '/themes/nangcuc/rating2/images/star-half.png',
        starOff: '/themes/nangcuc/rating2/images/star-off.png',
        starOn: '/themes/nangcuc/rating2/images/star-on.png',
        click: function (score, evt) {
            if (!rated) {
                $.ajax({
                    url: '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}',
                    data: JSON.stringify({
                        rating: score
                    }),
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function (res) {
                        alert("Đánh giá của bạn đã được gửi đi!");
                        console.log(res.avgRate);
                        $('#average').html(res.avgRate);
                        $('#rate_count').html(res.total_user_rate);
                        $('#star').attr('data-score', res.avgRate);
                        rated = true;
                    }
                });
            }
        }
    });
</script>