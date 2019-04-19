/*!

 @Title: Layui
 @Description锛氱粡鍏告ā鍧楀寲鍓嶇妗嗘灦
 @Site: www.layui.com
 @Author: 璐ゅ績
 @License锛歁IT

 */
 
;!function(win){
  "use strict";

  var doc = document, config = {
    modules: {} //璁板綍妯″潡鐗╃悊璺緞
    ,status: {} //璁板綍妯″潡鍔犺浇鐘舵€�
    ,timeout: 10 //绗﹀悎瑙勮寖鐨勬ā鍧楄姹傛渶闀跨瓑寰呯鏁�
    ,event: {} //璁板綍妯″潡鑷畾涔変簨浠�
  }

  ,Layui = function(){
    this.v = '2.1.5'; //鐗堟湰鍙�
  }

  //鑾峰彇layui鎵€鍦ㄧ洰褰�
  ,getPath = function(){
    var js = doc.scripts
    ,jsPath = js[js.length - 1].src;
    return jsPath.substring(0, jsPath.lastIndexOf('/') + 1);
  }()

  //寮傚父鎻愮ず
  ,error = function(msg){
    win.console && console.error && console.error('Layui hint: ' + msg);
  }

  ,isOpera = typeof opera !== 'undefined' && opera.toString() === '[object Opera]'

  //鍐呯疆妯″潡
  ,modules = {
    layer: 'modules/layer' //寮瑰眰
    ,laydate: 'modules/laydate' //鏃ユ湡
    ,laypage: 'modules/laypage' //鍒嗛〉
    ,laytpl: 'modules/laytpl' //妯℃澘寮曟搸
    ,layim: 'modules/layim' //web閫氳
    ,layedit: 'modules/layedit' //瀵屾枃鏈紪杈戝櫒
    ,form: 'modules/form' //琛ㄥ崟闆�
    ,upload: 'modules/upload' //涓婁紶
    ,tree: 'modules/tree' //鏍戠粨鏋�
    ,table: 'modules/table' //琛ㄦ牸
    ,element: 'modules/element' //甯哥敤鍏冪礌鎿嶄綔
    ,util: 'modules/util' //宸ュ叿鍧�
    ,flow: 'modules/flow' //娴佸姞杞�
    ,carousel: 'modules/carousel' //杞挱
    ,code: 'modules/code' //浠ｇ爜淇グ鍣�
    ,jquery: 'modules/jquery' //DOM搴擄紙绗笁鏂癸級
    
    ,mobile: 'modules/mobile' //绉诲姩澶фā鍧� | 鑻ュ綋鍓嶄负寮€鍙戠洰褰曪紝鍒欎负绉诲姩妯″潡鍏ュ彛锛屽惁鍒欎负绉诲姩妯″潡闆嗗悎
    ,'layui.all': '../layui.all' //PC妯″潡鍚堝苟鐗�
  };

  //璁板綍鍩虹鏁版嵁
  Layui.prototype.cache = config;

  //瀹氫箟妯″潡
  Layui.prototype.define = function(deps, callback){
    var that = this
    ,type = typeof deps === 'function'
    ,mods = function(){
      typeof callback === 'function' && callback(function(app, exports){
        layui[app] = exports;
        config.status[app] = true;
      });
      return this;
    };
    
    type && (
      callback = deps,
      deps = []
    );
    
    if(layui['layui.all'] || (!layui['layui.all'] && layui['layui.mobile'])){
      return mods.call(that);
    }
    
    that.use(deps, mods);
    return that;
  };

  //浣跨敤鐗瑰畾妯″潡
  Layui.prototype.use = function(apps, callback, exports){
    var that = this
    ,dir = config.dir = config.dir ? config.dir : getPath
    ,head = doc.getElementsByTagName('head')[0];

    apps = typeof apps === 'string' ? [apps] : apps;
    
    //濡傛灉椤甸潰宸茬粡瀛樺湪jQuery1.7+搴撲笖鎵€瀹氫箟鐨勬ā鍧椾緷璧杍Query锛屽垯涓嶅姞杞藉唴閮╦query妯″潡
    if(window.jQuery && jQuery.fn.on){
      that.each(apps, function(index, item){
        if(item === 'jquery'){
          apps.splice(index, 1);
        }
      });
      layui.jquery = layui.$ = jQuery;
    }
    
    var item = apps[0]
    ,timeout = 0;
    exports = exports || [];

    //闈欐€佽祫婧恏ost
    config.host = config.host || (dir.match(/\/\/([\s\S]+?)\//)||['//'+ location.host +'/'])[0];
    
    //鍔犺浇瀹屾瘯
    function onScriptLoad(e, url){
      var readyRegExp = navigator.platform === 'PLaySTATION 3' ? /^complete$/ : /^(complete|loaded)$/
      if (e.type === 'load' || (readyRegExp.test((e.currentTarget || e.srcElement).readyState))) {
        config.modules[item] = url;
        head.removeChild(node);
        (function poll() {
          if(++timeout > config.timeout * 1000 / 4){
            return error(item + ' is not a valid module');
          };
          config.status[item] ? onCallback() : setTimeout(poll, 4);
        }());
      }
    }
    
    //鍥炶皟
    function onCallback(){
      exports.push(layui[item]);
      apps.length > 1 ?
        that.use(apps.slice(1), callback, exports)
      : ( typeof callback === 'function' && callback.apply(layui, exports) );
    }
    
    //濡傛灉浣跨敤浜� layui.all.js
    if(apps.length === 0 
    || (layui['layui.all'] && modules[item]) 
    || (!layui['layui.all'] && layui['layui.mobile'] && modules[item])
    ){
      return onCallback(), that;
    }

    //棣栨鍔犺浇妯″潡
    if(!config.modules[item]){
      var node = doc.createElement('script')
      ,url =  (
        modules[item] ? (dir + 'lay/') : (config.base || '')
      ) + (that.modules[item] || item) + '.js';
      
      node.async = true;
      node.charset = 'utf-8';
      node.src = url + function(){
        var version = config.version === true 
        ? (config.v || (new Date()).getTime())
        : (config.version||'');
        return version ? ('?v=' + version) : '';
      }();
      
      head.appendChild(node);
      
      if(node.attachEvent && !(node.attachEvent.toString && node.attachEvent.toString().indexOf('[native code') < 0) && !isOpera){
        node.attachEvent('onreadystatechange', function(e){
          onScriptLoad(e, url);
        });
      } else {
        node.addEventListener('load', function(e){
          onScriptLoad(e, url);
        }, false);
      }
      
      config.modules[item] = url;
    } else { //缂撳瓨
      (function poll() {
        if(++timeout > config.timeout * 1000 / 4){
          return error(item + ' is not a valid module');
        };
        (typeof config.modules[item] === 'string' && config.status[item]) 
        ? onCallback() 
        : setTimeout(poll, 4);
      }());
    }
    
    return that;
  };

  //鑾峰彇鑺傜偣鐨剆tyle灞炴€у€�
  Layui.prototype.getStyle = function(node, name){
    var style = node.currentStyle ? node.currentStyle : win.getComputedStyle(node, null);
    return style[style.getPropertyValue ? 'getPropertyValue' : 'getAttribute'](name);
  };

  //css澶栭儴鍔犺浇鍣�
  Layui.prototype.link = function(href, fn, cssname){
    var that = this
    ,link = doc.createElement('link')
    ,head = doc.getElementsByTagName('head')[0];
    
    if(typeof fn === 'string') cssname = fn;
    
    var app = (cssname || href).replace(/\.|\//g, '')
    ,id = link.id = 'layuicss-'+app
    ,timeout = 0;
    
    link.rel = 'stylesheet';
    link.href = href + (config.debug ? '?v='+new Date().getTime() : '');
    link.media = 'all';
    
    if(!doc.getElementById(id)){
      head.appendChild(link);
    }

    if(typeof fn !== 'function') return that;
    
    //杞css鏄惁鍔犺浇瀹屾瘯
    (function poll() {
      if(++timeout > config.timeout * 1000 / 100){
        return error(href + ' timeout');
      };
      parseInt(that.getStyle(doc.getElementById(id), 'width')) === 1989 ? function(){
        fn();
      }() : setTimeout(poll, 100);
    }());
    
    return that;
  };

  //css鍐呴儴鍔犺浇鍣�
  Layui.prototype.addcss = function(firename, fn, cssname){
    return layui.link(config.dir + 'css/' + firename, fn, cssname);
  };

  //鍥剧墖棰勫姞杞�
  Layui.prototype.img = function(url, callback, error) {   
    var img = new Image();
    img.src = url; 
    if(img.complete){
      return callback(img);
    }
    img.onload = function(){
      img.onload = null;
      callback(img);
    };
    img.onerror = function(e){
      img.onerror = null;
      error(e);
    };  
  };

  //鍏ㄥ眬閰嶇疆
  Layui.prototype.config = function(options){
    options = options || {};
    for(var key in options){
      config[key] = options[key];
    }
    return this;
  };

  //璁板綍鍏ㄩ儴妯″潡
  Layui.prototype.modules = function(){
    var clone = {};
    for(var o in modules){
      clone[o] = modules[o];
    }
    return clone;
  }();

  //鎷撳睍妯″潡
  Layui.prototype.extend = function(options){
    var that = this;

    //楠岃瘉妯″潡鏄惁琚崰鐢�
    options = options || {};
    for(var o in options){
      if(that[o] || that.modules[o]){
        error('\u6A21\u5757\u540D '+ o +' \u5DF2\u88AB\u5360\u7528');
      } else {
        that.modules[o] = options[o];
      }
    }
    
    return that;
  };

  //璺敱瑙ｆ瀽
  Layui.prototype.router = function(hash){
    var that = this
    ,hash = hash || location.hash
    ,data = {
      path: []
      ,search: {}
      ,hash: (hash.match(/[^#](#.*$)/) || [])[1] || ''
    };
    
    if(!/^#\//.test(hash)) return data; //绂佹闈炶矾鐢辫鑼�
    hash = hash.replace(/^#\//, '').replace(/([^#])(#.*$)/, '$1').split('/') || [];
    
    //鎻愬彇Hash缁撴瀯
    that.each(hash, function(index, item){
      /^\w+=/.test(item) ? function(){
        item = item.split('=');
        data.search[item[0]] = item[1];
      }() : data.path.push(item);
    });

    return data;
  };

  //鏈湴瀛樺偍
  Layui.prototype.data = function(table, settings){
    table = table || 'layui';
    
    if(!win.JSON || !win.JSON.parse) return;
    
    //濡傛灉settings涓簄ull锛屽垯鍒犻櫎琛�
    if(settings === null){
      return delete localStorage[table];
    }
    
    settings = typeof settings === 'object' 
      ? settings 
    : {key: settings};
    
    try{
      var data = JSON.parse(localStorage[table]);
    } catch(e){
      var data = {};
    }
    
    if(settings.value) data[settings.key] = settings.value;
    if(settings.remove) delete data[settings.key];
    localStorage[table] = JSON.stringify(data);
    
    return settings.key ? data[settings.key] : data;
  };

  //璁惧淇℃伅
  Layui.prototype.device = function(key){
    var agent = navigator.userAgent.toLowerCase()

    //鑾峰彇鐗堟湰鍙�
    ,getVersion = function(label){
      var exp = new RegExp(label + '/([^\\s\\_\\-]+)');
      label = (agent.match(exp)||[])[1];
      return label || false;
    }
    
    //杩斿洖缁撴灉闆�
    ,result = {
      os: function(){ //搴曞眰鎿嶄綔绯荤粺
        if(/windows/.test(agent)){
          return 'windows';
        } else if(/linux/.test(agent)){
          return 'linux';
        } else if(/iphone|ipod|ipad|ios/.test(agent)){
          return 'ios';
        } else if(/mac/.test(agent)){
          return 'mac';
        } 
      }()
      ,ie: function(){ //ie鐗堟湰
        return (!!win.ActiveXObject || "ActiveXObject" in win) ? (
          (agent.match(/msie\s(\d+)/) || [])[1] || '11' //鐢变簬ie11骞舵病鏈塵sie鐨勬爣璇�
        ) : false;
      }()
      ,weixin: getVersion('micromessenger')  //鏄惁寰俊
    };
    
    //浠绘剰鐨刱ey
    if(key && !result[key]){
      result[key] = getVersion(key);
    }
    
    //绉诲姩璁惧
    result.android = /android/.test(agent);
    result.ios = result.os === 'ios';
    
    return result;
  };

  //鎻愮ず
  Layui.prototype.hint = function(){
    return {
      error: error
    }
  };

  //閬嶅巻
  Layui.prototype.each = function(obj, fn){
    var key
    ,that = this;
    if(typeof fn !== 'function') return that;
    obj = obj || [];
    if(obj.constructor === Object){
      for(key in obj){
        if(fn.call(obj[key], key, obj[key])) break;
      }
    } else {
      for(key = 0; key < obj.length; key++){
        if(fn.call(obj[key], key, obj[key])) break;
      }
    }
    return that;
  };

  //灏嗘暟缁勪腑鐨勫璞℃寜鍏舵煇涓垚鍛樻帓搴�
  Layui.prototype.sort = function(obj, key, desc){
    var clone = JSON.parse(
      JSON.stringify(obj)
    );
    
    if(!key) return clone;
    
    //濡傛灉鏄暟瀛楋紝鎸夊ぇ灏忔帓搴忥紝濡傛灉鏄潪鏁板瓧锛屾寜瀛楀吀搴忔帓搴�
    clone.sort(function(o1, o2){
      var isNum = /^-?\d+$/
      ,v1 = o1[key]
      ,v2 = o2[key];
      
      if(isNum.test(v1)) v1 = parseFloat(v1);
      if(isNum.test(v2)) v2 = parseFloat(v2);
      
      if(v1 && !v2){
        return 1;
      } else if(!v1 && v2){
        return -1;
      }
        
      if(v1 > v2){
        return 1;
      } else if (v1 < v2) {
        return -1;
      } else {
        return 0;
      }
    });

    desc && clone.reverse(); //鍊掑簭
    return clone;
  };

  //闃绘浜嬩欢鍐掓场
  Layui.prototype.stope = function(e){
    e = e || win.event;
    e.stopPropagation 
      ? e.stopPropagation() 
    : e.cancelBubble = true;
  };

  //鑷畾涔夋ā鍧椾簨浠�
  Layui.prototype.onevent = function(modName, events, callback){
    if(typeof modName !== 'string' 
    || typeof callback !== 'function') return this;
    config.event[modName + '.' + events] = [callback];
    
    //涓嶅啀瀵瑰娆′簨浠剁洃鍚仛鏀寔
    /*
    config.event[modName + '.' + events] 
      ? config.event[modName + '.' + events].push(callback) 
    : config.event[modName + '.' + events] = [callback];
    */
    
    return this;
  };

  //鎵ц鑷畾涔夋ā鍧椾簨浠�
  Layui.prototype.event = function(modName, events, params){
    var that = this
    ,result = null
    ,filter = events.match(/\(.*\)$/)||[] //鎻愬彇浜嬩欢杩囨护鍣�
    ,set = (events = modName + '.'+ events).replace(filter, '') //鑾峰彇浜嬩欢鏈綋鍚�
    ,callback = function(_, item){
      var res = item && item.call(that, params);
      res === false && result === null && (result = false);
    };
    layui.each(config.event[set], callback);
    filter[0] && layui.each(config.event[events], callback); //鎵ц杩囨护鍣ㄤ腑鐨勪簨浠�
    return result;
  };

  win.layui = new Layui();

}(window);
