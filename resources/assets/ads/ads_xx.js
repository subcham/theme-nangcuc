function detectMob() {
	const toMatch = [
		/Android/i,
		/webOS/i,
		/iPhone/i,
		/iPad/i,
		/iPod/i,
		/BlackBerry/i,
		/Windows Phone/i
	];

	return toMatch.some((toMatchItem) => {
		return navigator.userAgent.match(toMatchItem);
	});
}
var topAdsConf = {
	desktop: [],
	mobile: []
};
var footerFixAdsSequentially = {
	desktop: [],
	mobile: [
		{
			link: 'https://iwin.club/?a=iwin2_cpd-dongphymnet_bu&utm_source=dongphym.net&utm_medium=M_Catfish_vip_320x100&utm_campaign=CPD_S',
			image: 'https://i.imgur.com/L8GbBEQ.gif'
		},
		{
			link: 'https://game.taib52.vin/?a=b5_cpd-dongphymnet_bu&utm_source=dongphym.net&utm_medium=M_Catfish_vip_320x100&utm_campaign=CPD_S',
			image: 'https://i.imgur.com/SsD8IS8.gif'
		},
		{
			link: 'https://tai.rikvip.us/?a=rik_cpd-dongphymnet_bu&utm_source=dongphym.net&utm_medium=M_Catfish_vip_320x100&utm_campaign=CPD_S',
			image: 'https://i.imgur.com/1V41ljy.gif',
			alt: 'rikvip.us'
		}
	]
}
function showCatfishSequentially() {
	var itemAdsSe = null;
	var currentCatDes = $.cookie('current_CatDes');
	var currentCatMob = $.cookie('current_CatMob');

	var indexDes = currentCatDes ? parseInt(currentCatDes) : 0;
	var indexMob = currentCatMob ? parseInt(currentCatMob) : 0;
	var time__ = new Date(+new Date() + (60 * 30 * 1000));
	
	if (detectMob() || jQuery(window).width() <=768) {
		if (footerFixAdsSequentially.hasOwnProperty('mobile') && footerFixAdsSequentially.mobile.length > 0) {
			var newIndex = footerFixAdsSequentially.mobile[indexMob + 1] ? indexMob + 1 : 0;
			itemAdsSe = footerFixAdsSequentially.mobile[indexMob] ? footerFixAdsSequentially.mobile[indexMob] : footerFixAdsSequentially.mobile[0];
			$.cookie('current_CatMob', newIndex, { expires: time__, path: '/' });
		}
	} else {
		
	}
	var htmlShow = '';
	if (itemAdsSe !== null) {
		let altImg = itemAdsSe.hasOwnProperty('alt') ? itemAdsSe.alt : 'bet';
		htmlShow = `<div class="banner-sticky-footer-ad" style="max-width:100%;">
		<div class="banner-flex">
			<div class="ad_close_popup" id="ad_close_popup2" onclick="closeFloatFooter($(this));" style="height: 25px;"><img width="23" height="23" src="/close_button.png" alt="close" title="close"></div>
			<div class="ad-sticky-content" style="max-height:100px;overflow:hidden; text-align:center;" id="ad_pc_bottom_float">
			<a rel="nofollow sponsored" href="`+itemAdsSe.link+`">
				<img width="320" height="100" src="`+itemAdsSe.image+`" title="`+altImg+`" alt="`+altImg+`"/>
			</a>
			</div>
		</div>
		</div>`;
	}
	
	return htmlShow;
}
var footerFixAds = {
	desktop: [
		{
			link: 'https://www.i9bet70.com/Register?a=34869',
			image: 'https://cdn2-img.net/i999bet-728x60.gif',
			alt: 'i9bet6'
		}
	],
	mobile: [
		{
			link: 'https://www.i9bet70.com/Register?a=34869',
			image: 'https://cdn2-img.net/i999bet-320x40.gif',
			alt: 'i9bet6'
		}
	]
};

var overlayAds = {
	desktop: [],
	mobile: []
}

function closeFloatFooter(__this){
	__this.closest('.banner-sticky-footer-ad').remove();
}
function getOverAdsItemByDevice(device = 'desktop') {
	var cookieOIndex = $.cookie('o_item_index');
	var time__ = new Date(+new Date() + (60 * 30 * 1000));
	
	//var cookieValue = cookieOIndex == 0 ? 0 : 0;
	var cookieValue = 0;
	$.cookie('o_item_index', cookieValue, { expires: time__, path: '/' });
	if (device == 'desktop') {
		return overlayAds.desktop[cookieValue];
	} else {
		return overlayAds.mobile[cookieValue];
	}
	
}
function showOverlayAds() {
	var itemAds = '';
	let adsItemObj = '';
	if (detectMob() || jQuery(window).width() <=768) {
		if (overlayAds.hasOwnProperty('mobile') && overlayAds.mobile.length > 0) {
			adsItemObj = getOverAdsItemByDevice('mobile')
		}
	} else {
		if (overlayAds.hasOwnProperty('desktop') && overlayAds.desktop.length > 0) {
			adsItemObj = getOverAdsItemByDevice('desktop')
		}
	}
	if (adsItemObj != '' && adsItemObj.hasOwnProperty('image')) {
		let imagewidth = adsItemObj.width || 350
		itemAds += `<div class="overlay_block">
						<a href="javascript:void(0)" class="cls_ov">Đóng QC [&times;]</a>
						<a rel="nofollow sponsored aaa" href="`+adsItemObj.link+`"><img width="`+imagewidth+`" src="`+adsItemObj.image+`"/></a>
					</div>`;
	}
	console.log(itemAds)
	// var cookieOvAds = $.cookie('overlayads_display');
	// if (!cookieOvAds) {
		// countshow = 0;
	// } else {
		// countshow = cookieOvAds;
	// }
	// if (countshow <= 1 && itemAds != '') {
		// itemAdsHtml = `<div class="overlay_content">
				// <div class="overlay_wrapper">${itemAds}</div>
			// </div>`;
		// $('#overlay').html(itemAdsHtml);
		// $('#overlay').show();
		// var time__ = new Date(+new Date() + (60 * 30 * 1000));
		// countshow++;
		// $.cookie('overlayads_display', countshow, { expires: time__, path: '/' });
	// }
	var cookieOvAds = $.cookie('overlayads_display');
	if (!cookieOvAds && itemAds != '') {
		let itemAdsHtml = `<div class="overlay_content"><div class="overlay_wrapper">${itemAds}</div></div>`;
		$('#overlay').html(itemAdsHtml);
		$('#overlay').show();
		var time__ = new Date(+new Date() + (60 * 60 * 500));
		$.cookie('overlayads_display', 1, { expires: time__, path: '/' });
	}
}
function randomIntFromInterval(min, max) { // min and max included 
  return Math.floor(Math.random() * (max - min + 1) + min)
}
function shuffleArray(d) {
  for (var c = d.length - 1; c > 0; c--) {
    var b = Math.floor(Math.random() * (c + 1));
    var a = d[c];
    d[c] = d[b];
    d[b] = a;
  }
  return d
}
function showTopads() {
	var itemAds = '';
	//const arrayRan = [[1,2], [3,4]];
	const arrayRan = [8,9];
	var random = randomIntFromInterval(0,1);
	var showAd = [arrayRan[random]];
	if (detectMob() || jQuery(window).width() <=768) {
		if (topAdsConf.hasOwnProperty('mobile') && topAdsConf.mobile.length > 0) {
			$.each(topAdsConf.mobile, function(i, item) {
				if (!showAd.includes(i)) {
					let altImg = item.hasOwnProperty('alt') ? item.alt : 'bet';
				itemAds += `<div class="text-center">
					<a rel="nofollow sponsored" href="`+item.link+`">
						<img width="320" height="40" src="`+item.image+`" alt="`+altImg+`" />
					</a>
				</div>`;
				}
			});
		}
	} else {
		if (topAdsConf.hasOwnProperty('desktop') && topAdsConf.desktop.length > 0) {
			$.each(topAdsConf.desktop, function(i, item) {
				if (!showAd.includes(i)) {
					let altImg = item.hasOwnProperty('alt') ? item.alt : 'bet';
					itemAds += `<div class="text-center">
						<a rel="nofollow sponsored" href="`+item.link+`">
							<img width="728" height="60" src="`+item.image+`" alt="`+altImg+`" />
						</a>
					</div>`;
				}
			});
		}
	}
	$('#top_oddd').html(itemAds);
}
function showFooterFixAds() {
	var itemAds = '';
	if (detectMob() || jQuery(window).width() <=768) {
		if (footerFixAds.hasOwnProperty('mobile') && footerFixAds.mobile.length > 0) {
			$.each(footerFixAds.mobile, function(i, item) {
				let altImg = item.hasOwnProperty('alt') ? item.alt : 'bet';
				itemAds += `<div class="banner-sticky-footer-ad" style="max-width:100%;">
<div class="banner-flex">
	<div class="ad_close_popup" id="ad_close_popup2" onclick="closeFloatFooter($(this));" style="height: 25px;"><img width="23" height="23" src="/close_button.png" alt="close" title="close"></div>
	<div class="ad-sticky-content" style="max-height:100px;overflow:hidden; text-align:center;" id="ad_pc_bottom_float">
	<a rel="nofollow sponsored" href="`+item.link+`">
		<img width="320" height="40" src="`+item.image+`" title="`+altImg+`" alt="`+altImg+`"/>
	</a>
	</div>
</div>
</div>`;
			});
		}
	} else {
		if (footerFixAds.hasOwnProperty('desktop') && footerFixAds.desktop.length > 0) {
			$.each(footerFixAds.desktop, function(i, item) {
				let altImg = item.hasOwnProperty('alt') ? item.alt : 'bet';
				itemAds += `<div class="banner-sticky-footer-ad" style="max-width:728px;">
<div class="banner-flex">
	<div class="ad_close_popup" id="ad_close_popup2" onclick="closeFloatFooter($(this));" style="height: 25px;"><img width="23" height="23" src="/close_button.png" alt="close" title="close"></div>
	<div class="ad-sticky-content" style="max-height:100px;overflow:hidden; text-align:center;" id="ad_pc_bottom_float">
	<a rel="nofollow sponsored" href="`+item.link+`">
		<img width="728" height="60" src="`+item.image+`" title="`+altImg+`" style="max-width:100%; overflow:hidden;" alt="`+altImg+`"/>
	</a>
	</div>
</div>
</div>`;
			});
		}
	}
	//var htmlAdsSequent = showCatfishSequentially();
	var htmlAdsSequent = '';
	var htmlAds = '';
	if (itemAds != '') {
		htmlAds = '<div class="banner-sticky-footer-wrapper"><div class="banner-sticky-footer-container container">'+htmlAdsSequent+itemAds+'</div></div>';
		$('#footer_fixed_ads').html(htmlAds);
	}
}
$(document).ready(function () {
	// if (!detectMob()) {
		// var script = document.createElement('script');
		// script.setAttribute('type', 'text/javascript');
		// script.setAttribute('src', '//juringupstage.com/fYTj8rljzh6f5xUHY/32557');
		// document.body.appendChild(script);
	// }
	showTopads();
	showFooterFixAds();
	showOverlayAds();
});
jQuery(window).on('resize', function () {
	// showTopads();
	// showFooterFixAds();
	// showOverlayAds();
});
$('body').on('click', '#overlay .overlay_content .cls_ov', function () {
	$(this).closest('#overlay').hide();
});