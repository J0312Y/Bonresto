"use strict";

// ==========================
// 🔹 Owl Carousel
// ==========================
$('.category_slider').owlCarousel({
    loop: false,
    margin: 10,
    responsiveClass: true,
    nav: false,
    navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
    responsive: {
        0: { items: 4 },
        400: { items: 4 },
        480: { items: 5 },
        650: { items: 6 }
    }
});

$(document).on('click', '.sa-clicon', function() {
    swal.close();
});

function scrollNav() {
    $('.goto').click(function() {
        $(".active").removeClass("active");
        $(this).addClass("active");
        $('html, body').stop().animate({
            scrollTop: $($(this).attr('href')).offset().top - 200
        }, 300);
        return false;
    });
}
scrollNav();

$(".simple_btn").click(function() {
    $(this).addClass("d-none");
    $(this).siblings(".cart_counter").addClass("active");
});

$(".adonsclose").click(function() {
    var id = $("#mainqrid").val();
    $("#backadd" + id).removeClass("d-none");
    $("#removeqtyb" + id).removeClass("active").addClass("hidden_cart");
});

// ==========================
// 🔹 Cart functions
// ==========================
function changeqty(pid, vid, id) {
    var getqty = $("#sst" + id).val();
    var dataString = "CartID=" + rowid + '&qty=' + getqty+'&csrf_test_name='+basicinfo.csrftokeng;
    var myurl = base_url + 'cartupdate';
    $.ajax({ type: "POST", url: myurl, data: dataString });
}

function itemreduce(pid, vid, id) {
    var result = document.getElementById('sst' + id);
    var sstid = result.value;
    if (!isNaN(sstid) && sstid > 0) result.value--;
    if (sstid <= 1) {
        $("#sst" + id).val(1);
        $("#backadd" + id).removeClass("d-none");
        $("#removeqtyb" + id).removeClass("active").addClass("hidden_cart");
    }
    var reduce = "del";
    var qty = sstid;
    var itemname = $("#itemname_" + id).val();
    var sizeid = $("#sizeid_" + id).val();
    var varientname = $("#varient_" + id).val();
    var price = $("#itemprice_" + id).val();
    var catid = $("#catid_" + id).val();
    var myurl = basicinfo.baseurl+'hungry/deltocartqr/';
    var dataString = "pid=" + pid + '&itemname=' + itemname + '&varientname=' + varientname + '&qty=' + qty + '&price=' + price + '&catid=' + catid + '&sizeid=' + sizeid + '&Udstatus=' + reduce+'&csrf_test_name='+basicinfo.csrftokeng;
    $.ajax({
        type: "POST",
        url: myurl,
        data: dataString,
        success: function(data) {
            $("#cartitemandprice").val(data);
            $("#badgeshow").text(data).removeClass('badgedisplaynone').addClass('badgedisplayblock');
        }
    });
}

function itemincrese(pid, vid, id) {
    var result = document.getElementById('sst' + id);
    var sstid = result.value;
    if (!isNaN(sstid)) result.value++;
    var reduce = "addstatus";
    var itemname = $("#itemname_" + id).val();
    var sizeid = $("#sizeid_" + id).val();
    var varientname = $("#varient_" + id).val();
    var qty = $("#sst" + id).val();
    var price = $("#itemprice_" + id).val();
    var catid = $("#catid_" + id).val();
    var myurl = basicinfo.baseurl+'addtocartqr/';
    var dataString = "pid=" + pid + '&itemname=' + itemname + '&varientname=' + varientname + '&qty=' + qty + '&price=' + price + '&catid=' + catid + '&sizeid=' + sizeid + '&Udstatus=' + reduce+'&csrf_test_name='+basicinfo.csrftokeng;
    $.ajax({
        type: "POST",
        url: myurl,
        data: dataString,
        success: function(data) {
            $("#cartitemandprice").val(data);
            $("#badgeshow").text(data).removeClass('badgedisplaynone').addClass('badgedisplayblock');
        }
    });
}

function appcart(pid, vid, id) {
    $("#sst" + id).val(1);
    var itemname = $("#itemname_" + id).val();
    var sizeid = $("#sizeid_" + id).val();
    var varientname = $("#varient_" + id).val();
    var qty = $("#sst" + id).val();
    var price = $("#itemprice_" + id).val();
    var catid = $("#catid_" + id).val();
    var reduce = "insert";
    var myurl = basicinfo.baseurl+'addtocartqr/';
    var dataString = "pid=" + pid + '&itemname=' + itemname + '&varientname=' + varientname + '&qty=' + qty + '&price=' + price + '&catid=' + catid + '&sizeid=' + sizeid + '&Udstatus=' + reduce+'&csrf_test_name='+basicinfo.csrftokeng;
    $.ajax({
        type: "POST",
        url: myurl,
        dataType: "text",
        async: false,
        data: dataString,
        success: function(data) {
            $("#cartitemandprice").val(data);
            $("#badgeshow").text(data).removeClass('badgedisplaynone').addClass('badgedisplayblock');
        }
    });
}

// ==========================
// 🔹 Addons
// ==========================
function addonsitemqr(id, sid, type) {
    var myurl = basicinfo.baseurl+'hungry/addonsitemqr/' + id;
    var dataString = "pid=" + id + "&sid=" + sid + '&type=' + type+'&csrf_test_name='+basicinfo.csrftokeng;
    $.ajax({
        type: "POST",
        url: myurl,
        data: dataString,
        success: function(data) {
            $('.addonsinfo').html(data);
            $('#addons').modal('show');
        }
    });
}

function addonsfoodtocart(pid, id, type) {
    var addons = [];
    var adonsqty = [];
    var allprice = 0;
    var adonsprice = [];
    var adonsname = [];
    $('input[name="addons"]:checked').each(function() {
        var adnsid = $(this).val();
        var adsqty = $('#addonqty_' + adnsid).val();
        adonsqty.push(adsqty);
        addons.push($(this).val());
        allprice += parseFloat($(this).attr('role')) * parseInt(adsqty);
        adonsprice.push($(this).attr('role'));
        adonsname.push($(this).attr('title'));
    });
    var mid = $("#mainqrid").val();
    var reduce = "insert";
    var catid = $("#catid_1" + mid).val();
    var itemname = $("#itemname_1" + mid).val();
    var sizeid = $("#sizeid_1" + mid).val();
    var varientname = $("#varient_1" + mid).val();
    var qty = $("#sst61_" + mid).val();
    var price = $("#itemprice_1" + mid).val();
    var myurl = basicinfo.baseurl+'addtocartqr/';
    var dataString = "pid=" + pid + '&itemname=' + itemname + '&varientname=' + varientname + '&qty=' + qty + '&price=' + price + '&catid=' + catid + '&sizeid=' + sizeid + '&addonsid=' + addons + '&allprice=' + allprice + '&adonsunitprice=' + adonsprice + '&adonsqty=' + adonsqty + '&adonsname=' + adonsname + '&Udstatus=' + reduce+'&csrf_test_name='+basicinfo.csrftokeng;
    $.ajax({
        type: "POST",
        url: myurl,
        data: dataString,
        success: function(data) {
            $("#backadd" + mid).addClass("d-none");
            $('#addons').modal('hide');
            $("#cartitemandprice").val(data);
            $("#badgeshow").text(data).removeClass('badgedisplaynone').addClass('badgedisplayblock');
        }
    });
}

// ==========================
// 🔹 Search
// ==========================
function getfoodlist() {
    var foodname = $("#foodname").val();
    var dataString = "foodname=" + foodname+'&csrf_test_name='+basicinfo.csrftokeng;
    $.ajax({
        type: "POST",
        url: basicinfo.baseurl+'hungry/searchqrfood',
        data: dataString,
        success: function(data) {
            $("#searchqritem").html(data);
        }
    });
}
$(".searchIcon").click(function() { $(".search_filter").addClass("active"); });
$(".close-icon").click(function() { $(".search_filter").removeClass("active"); });

// ==========================
// 🔹 Firebase Messaging Setup
// ==========================
const firebaseConfig = {
    apiKey: "AIzaSyCm2qFBF085Y9hPLr7BmKJBxQx_wWqwIAE",
    authDomain: "restaurantqrapp-ea222.firebaseapp.com",
    databaseURL: "https://restaurantqrapp-ea222-default-rtdb.firebaseio.com/",
    projectId: "restaurantqrapp-ea222",
    storageBucket: "restaurantqrapp-ea222.firebasestorage.app",
    messagingSenderId: "772898595253",
    appId: "1:772898595253:web:7c182c663e7327938579fc",
    measurementId: "G-M6WZJTBZWC"
};
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

navigator.serviceWorker.register('/Bonresto/firebase-messaging-sw.js')
.then(registration => {
    console.log("✅ Service Worker registered:", registration);
    messaging.useServiceWorker(registration);
    return messaging.requestPermission();
})
.then(() => getRegToken())
.catch(err => console.error("❌ Notification permission error:", err));

function getRegToken() {
    messaging.getToken()
    .then(currentToken => {
        if (currentToken) {
            console.log("🎯 FCM Token:", currentToken);
            saveTokenToServer(currentToken);
        } else {
            console.warn("⚠️ No registration token available.");
        }
    })
    .catch(err => console.error("❌ Error retrieving FCM token:", err));
}

function saveTokenToServer(token) {
    $.ajax({
        url: basicinfo.baseurl + 'hungry/savetoken/',
        method: 'POST',
        data: { token: token, csrf_test_name: basicinfo.csrftokeng }
    }).done(res => console.log("✅ Token saved on server:", res));
}

messaging.onMessage(payload => {
    console.log('🔔 Message received:', payload);
    const notificationTitle = payload.notification?.title || 'New Notification';
    const notificationOptions = {
        body: payload.notification?.body || 'You have a new message.',
        icon: payload.notification?.icon || '/Bonresto/assets/images/icon.png',
        image: payload.notification?.image || '/Bonresto/assets/images/notification.png'
    };
    if (Notification.permission === 'granted') {
        navigator.serviceWorker.getRegistration().then(reg => {
            if (reg) reg.showNotification(notificationTitle, notificationOptions);
        });
    }
});
function orderlist(){
			var islogin=$("#isloginuser").val();
			if(islogin!=''){
					window.location.href=basicinfo.baseurl+"apporedrlist";
				}else{
					swal("", lang.apporderempty, "warning");
					}
			}
function gotoappcart(){
			var cartdat=$("#cartitemandprice").val();
			if(cartdat>0){
				window.location.href=basicinfo.baseurl+"qr-app-cart";
			}else{
				swal("", lang.appcartempty, "warning");
				}
			}
// ==========================
// 🔹 Test “one-click” notification
// ==========================
/*function sendTestNotification() {
    $.ajax({
        url: basicinfo.baseurl + 'hungry/send_test_notification',
        method: 'POST',
        data: { csrf_test_name: basicinfo.csrftokeng }
    }).done(res => console.log("✅ Test notification sent:", res));
}*/
/* ===============================
   🔹 Firebase Cloud Messaging
================================ */
// ==========================
// 🔹 Expose to global scope for onclick
// ==========================
window.orderlist = orderlist;
window.gotoappcart = gotoappcart;
