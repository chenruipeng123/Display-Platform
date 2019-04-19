	<script type="text/javascript">
		if (!Object.keys) {
		  Object.keys = (function () {
		    var hasOwnProperty = Object.prototype.hasOwnProperty,
		        hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
		        dontEnums = [
		          'toString',
		          'toLocaleString',
		          'valueOf',
		          'hasOwnProperty',
		          'isPrototypeOf',
		          'propertyIsEnumerable',
		          'constructor'
		        ],
		        dontEnumsLength = dontEnums.length;
		 
		    return function (obj) {
		      if (typeof obj !== 'object' && typeof obj !== 'function' || obj === null) throw new TypeError('Object.keys called on non-object');
		 
		      var result = [];
		 
		      for (var prop in obj) {
		        if (hasOwnProperty.call(obj, prop)) result.push(prop);
		      }
		 
		      if (hasDontEnumBug) {
		        for (var i=0; i < dontEnumsLength; i++) {
		          if (hasOwnProperty.call(obj, dontEnums[i])) result.push(dontEnums[i]);
		        }
		      }
		      return result;
		    }
		  })()
		};
	</script>
	<script type="text/javascript" src="layui/layui.js"></script>
	<script>
		layui.use('layer', function () {
			var $ = layui.jquery,
				layer = layui.layer;
			$('.btn').on('click', function () {
				var value = $(this).attr("value");
				$("#iframe").attr("src","show.php?id="+value);
				layer.open({
					type: 1,
					title: false,
					content: $('#show_area'),
					area: ['1600px', '900px'],
					closeBtn: 2,
					shadeClose: true,
					scrollbar: false,
				});
				
			});
		});
	</script>
	<script type="text/javascript" src="js/idangerous.swiper.min.js"></script>
	<script>
		// var swiper = new Swiper('.swiper-container', {
		// 	direction: 'vertical',autoHeight:true
		// });
		// var startScroll, touchStart, touchCurrent;
		// $(".swiper_content").on('touchstart', function (e) {
		// 	startScroll = this.scrollTop;
		// 	touchStart = e.targetTouches[0].pageY;
		// }, true); 
		// $(".swiper_content").on('touchmove', function (e) {
		// 	touchCurrent = e.targetTouches[0].pageY;
		// 	var touchesDiff = touchCurrent - touchStart;
		// 	var slide = this;
		// 	var onlyScrolling =
		// 			( slide.scrollHeight > slide.offsetHeight ) && //allow only when slide is scrollable
		// 			(
		// 				( touchesDiff < 0 && startScroll === 0 ) || //start from top edge to scroll bottom
		// 				( touchesDiff > 0 && startScroll === ( slide.scrollHeight - slide.offsetHeight ) ) || //start from bottom edge to scroll top
		// 				( startScroll > 0 && startScroll < ( slide.scrollHeight - slide.offsetHeight ) ) //start from the middle
		// 			);
		// 	if (onlyScrolling) {
		// 		e.stopPropagation();
		// 	}
		// }, true);
	</script>
    <script type="text/javascript" src="js/index.js"></script>
</body>
</html>