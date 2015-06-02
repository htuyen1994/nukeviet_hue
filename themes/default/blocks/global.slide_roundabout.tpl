<!-- BEGIN: main -->
 <script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/global.slide_roundabout/jquery.roundabout.min.js"></script>  
 <script type="text/javascript">
 //global.slide_roundabout
 $(window).load(function() {
	$('ul#sample').roundabout({
		autoplay: true,
		autoplayDuration: {DURATION},		//3000	{DURATION}
		autoplayPauseOnHover: true,
		/**/
		enableDrag : true
	});
});
 
</script> 
	<style> 
@media screen and (min-width:1025px){.roundabout-holder {height: 300px;}}
@media screen and (max-width:1024px) and (min-width:769px) { .roundabout-holder {height: 250px;}}
@media screen and (max-width:768px) and (min-width:641px) { .roundabout-holder {height: 220px;}.thaotrinh p {display:none}}
@media screen and (max-width:640px) and (min-width:481px) {.roundabout-holder {height: 180px;}.thaotrinh p {display:none}}
@media screen and (max-width:480px) and (min-width:321px) {.roundabout-holder {height: 150px;}.thaotrinh p {display:none}}
@media screen and (max-width:320px) {.roundabout-holder {height: 100px;}.thaotrinh p {display:none}}
.roundabout-holder {padding: 0;margin: 0 auto; width:80%;}
.roundabout-moveable-item {height: auto; width:50%;cursor: pointer;  display:block;}
.roundabout-moveable-item img {height: 100%;width: 100%;cursor: crosshair;}
.roundabout-in-focus {cursor: auto;}
/*****/
#slide_roundabout {width: inherit;margin: 15px auto;/*overflow: hidden;*/} 		/*{MARGIN}*/
#slide_roundabout *{text-decoration:none;}
#slide_roundabout div h3 {color: {COLORTITLE};padding: 0 9px;white-space: nowrap;text-shadow: 0 -1px 0 #111;border-bottom: 1px dashed #ccc;overflow: hidden;}
#slide_roundabout div p {color: {COLOREXCERPT};padding: 0 9px;text-shadow: 0 -1px 0 #111;}
#slide_roundabout div h3:hover {color:{COLORTITLEH};padding: 0 9px;white-space: nowrap;text-shadow: 0 -1px 0 #111;	}
#slide_roundabout div p:hover {color:{COLOREXCERPTH};padding: 0 9px;text-shadow: 0 -1px 0 #111;}
/***/
#slide_roundabout .posR {position:relative;}
#slide_roundabout .posA {position:absolute;}
#slide_roundabout .oveH {overflow: hidden;}
#slide_roundabout .traA15e {-webkit-transition: all 1.5s ease;-moz-transition: all 1.5s ease;transition: all 1.5s ease;}
#slide_roundabout .w100 {width: 100%;}
#slide_roundabout .heiA {height:auto;}
#slide_roundabout .disN{display:none}
/****/
#slide_roundabout .thaotrinh	{position:relative; overflow: hidden;box-shadow: 0 0 2px #111;}
#slide_roundabout .thaotrinh .opaH01 {opacity:0;}
#slide_roundabout .thaotrinh:hover .opaH01 {opacity:1;}
#slide_roundabout .thaotrinh .transition {}
#slide_roundabout .thaotrinh div{background:{BACKGROUND};}		/*#333	{BACKGROUND} */
/******/
#slide_roundabout .thaotrinh .toBottom { bottom:100%; } {}
#slide_roundabout .thaotrinh:hover .toBottom {bottom:{TOBOTTOM}%;} /*40%	{toBottom} */
/********/
#slide_roundabout .thaotrinh .toTop {top:100%; }
#slide_roundabout .thaotrinh:holeftCver .toTop {top:{TOTOP}%;}	/*50%	{toTop} */
/*****/
#slide_roundabout .thaotrinh .toRight { left:-100%;bottom:{TORIGHT}%; } /*	15%{toRight} */
#slide_roundabout .thaotrinh:hover .toRight {left:0px;}	
/******/
#slide_roundabout .thaotrinh .toLeft { right:-100%; bottom:{TOLEFT}%;} /*15%	{toLeft} */
#slide_roundabout .thaotrinh:hover .toLeft {right:0px;}	

#slide_roundabout .thaotrinh .fixedBot{bottom: 0;left:0;opacity:0.7;}
#slide_roundabout .thaotrinh .hidden{display:none;}
/*
Có 6 trường hợp:
fixedBot bottom
display none
top -> bottom
bottom -> top
left -> right
right -> left 
*/
	</style>
<div id="slide_roundabout">
 <ul id="sample" >
	<!-- BEGIN: loop -->
		<li class="thaotrinh"><img src="{IMGSRC}"  alt="{TITLE}" />
			<div class="{STYLE} posA opaH01 traA15e w100"> 
				<a href="{AHREF}" target="{ATARGET}"><h3>{TITLE}</h3></a><p>{EXCERPT} </p> </div>  </li>
	<!-- END: loop -->
	</ul>
</div>

<!-- END: main -->