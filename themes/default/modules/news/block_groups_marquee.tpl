<!-- BEGIN: main -->
<script type="text/javascript">
	$(function() {
		$('marquee').marquee('pointer').mouseover(function() {
			$(this).trigger('stop');
		}).mouseout(function() {
			$(this).trigger('start');
		}).mousemove(function(event) {
			if ($(this).data('drag') == true) {
				this.scrollLeft = $(this).data('scrollX') + ($(this).data('x') - event.clientX);
			}
		}).mousedown(function(event) {
			$(this).data('drag', true).data('x', event.clientX).data('scrollX', this.scrollLeft);
		}).mouseup(function() {
			$(this).data('drag', false);
		});
	});
</script>
<div id="blockid_{DATA.bid}">
	<marquee behavior="scroll" scrollamount="{DATA.scroll}" direction="{DATA.direction}">
		<!-- BEGIN: loop -->
		<!-- BEGIN: newday -->
		<img src="{NV_BASE_SITEURL}themes/{THEME}/images/{MODULE}/new.gif" alt="{ROW.title}" />
		<!-- END: newday -->
		<a href="{ROW.link}" title="{ROW.title}">{ROW.title}</a>&nbsp;&nbsp;&nbsp;&nbsp;
		<!-- END: loop -->
	</marquee>
</div>

<!-- END: main -->