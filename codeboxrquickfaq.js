/*
Codeboxr QuickFaq

*/

jQuery(function($){
    $(document).ready(function(){
        $("div.cbquickfaqwrap").each(function(){


            var dataclose = $(this).attr('data-allclose');

            if(dataclose == 1 || dataclose == '1'){              //by default value 1 and it will close all other when one faq is open
                //console.log("hi there");
                $(this). find(".cbquickfaqcontent").not(':eq(0)').hide();      //all except the first one is close
                $(this). find(".cbquickfaqheader").eq(0).addClass('active');      //icon change to number one child

                $(this).find('.cbquickfaqheader').click(function(){

                    var next= $(this).next('.cbquickfaqcontent');
                    $(this).parents('.cbquickfaqwrap').find('.cbquickfaqcontent').not(next).slideUp("slow");
                    next.slideToggle("slow");
                    $(this).toggleClass('active').parents('.cbquickfaqwrap').find('.cbquickfaqheader').not(this).removeClass('active');


                });

            }// end of all close
            else{

                $(this).find(".cbquickfaqcontent").hide();              //hides all children at first if dataclose value 0

                $(this).find('.cbquickfaqheader').click(function(){   //
                    $(this).toggleClass("active").next().slideToggle("normal");
                    return false; //Prevent the browser jump to the link anchor
                });

            }// end of else all close
        });// end of each div
    });// end of dom ready

});





