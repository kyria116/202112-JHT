$((function(){$(".product-number").on("click",(function(){$("#modalBg").css("display","block"),$("body").addClass("modal-open")})),$("#close").on("click",(function(){$("#modalBg").css("display","none"),$("body").removeClass("modal-open")}));const s=document.getElementById("modalBg"),e=document.getElementById("myModal");s.addEventListener("click",(function(s){$("#modalBg").css("display","none"),$("body").removeClass("modal-open"),s.stopPropagation()}),!1),e.addEventListener("click",(function(s){s.stopPropagation()}),!1)}));var index=$(".sel-bx li").length;1==index&&$(".remove-btn").addClass("hid"),$(".remove-btn").on("click",(function(){var s=$(".sel-bx > li").length;$(".sel-bx > li").eq(s-1).remove(),2==s&&$(this).addClass("hid")}));var sel=$(".sel-bx li").eq(0).html();$(".add-btn").on("click",(function(){var s=$(".sel-bx li").length;$(".sel-bx").append(`<li>${sel}</li>`),$(".product_id").chosen(),s>0&&$(".remove-btn").removeClass("hid"),$("select").on("change",(function(){"N"==$(this).val()?$(this).removeClass("chsel"):$(this).addClass("chsel")}))})),$("input[type=radio]").on("change",(function(){console.log($(this).val()),"s-2"==$(this).val()?($(".shopsel").addClass("show"),$(".shopsel2").removeClass("show"),$(".shopsel3").removeClass("show"),$(".shopsel4").removeClass("show")):"s-1"==$(this).val()?($(".shopsel").removeClass("show"),$(".shopsel2").addClass("show"),$(".shopsel3").removeClass("show"),$(".shopsel4").removeClass("show")):"s-3"==$(this).val()?($(".shopsel").removeClass("show"),$(".shopsel2").removeClass("show"),$(".shopsel3").addClass("show"),$(".shopsel4").removeClass("show")):"s-4"==$(this).val()&&($(".shopsel").removeClass("show"),$(".shopsel2").removeClass("show"),$(".shopsel3").removeClass("show"),$(".shopsel4").addClass("show"))}));