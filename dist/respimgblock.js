!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s="./src/js/admin/image-block.js")}({"./node_modules/object-assign/index.js":function(e,t,n){"use strict";var r=Object.getOwnPropertySymbols,o=Object.prototype.hasOwnProperty,a=Object.prototype.propertyIsEnumerable;e.exports=function(){try{if(!Object.assign)return!1;var e=new String("abc");if(e[5]="de","5"===Object.getOwnPropertyNames(e)[0])return!1;for(var t={},n=0;n<10;n++)t["_"+String.fromCharCode(n)]=n;if("0123456789"!==Object.getOwnPropertyNames(t).map(function(e){return t[e]}).join(""))return!1;var r={};return"abcdefghijklmnopqrst".split("").forEach(function(e){r[e]=e}),"abcdefghijklmnopqrst"===Object.keys(Object.assign({},r)).join("")}catch(e){return!1}}()?Object.assign:function(e,t){for(var n,i,u=function(e){if(null===e||void 0===e)throw new TypeError("Object.assign cannot be called with null or undefined");return Object(e)}(e),l=1;l<arguments.length;l++){for(var c in n=Object(arguments[l]))o.call(n,c)&&(u[c]=n[c]);if(r){i=r(n);for(var s=0;s<i.length;s++)a.call(n,i[s])&&(u[i[s]]=n[i[s]])}}return u}},"./node_modules/prop-types/checkPropTypes.js":function(e,t,n){"use strict";var r=function(){},o=n("./node_modules/prop-types/lib/ReactPropTypesSecret.js"),a={},i=Function.call.bind(Object.prototype.hasOwnProperty);function u(e,t,n,u,l){for(var c in e)if(i(e,c)){var s;try{if("function"!=typeof e[c]){var f=Error((u||"React class")+": "+n+" type `"+c+"` is invalid; it must be a function, usually from the `prop-types` package, but received `"+typeof e[c]+"`.");throw f.name="Invariant Violation",f}s=e[c](t,c,u,n,null,o)}catch(e){s=e}if(!s||s instanceof Error||r((u||"React class")+": type specification of "+n+" `"+c+"` is invalid; the type checker function must return `null` or an `Error` but returned a "+typeof s+". You may have forgotten to pass an argument to the type checker creator (arrayOf, instanceOf, objectOf, oneOf, oneOfType, and shape all require an argument)."),s instanceof Error&&!(s.message in a)){a[s.message]=!0;var p=l?l():"";r("Failed "+n+" type: "+s.message+(null!=p?p:""))}}}r=function(e){var t="Warning: "+e;"undefined"!=typeof console&&console.error(t);try{throw new Error(t)}catch(e){}},u.resetWarningCache=function(){a={}},e.exports=u},"./node_modules/prop-types/lib/ReactPropTypesSecret.js":function(e,t,n){"use strict";e.exports="SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"},"./node_modules/react/cjs/react.development.js":function(e,t,n){"use strict";(function(){var e=n("./node_modules/object-assign/index.js"),r=n("./node_modules/prop-types/checkPropTypes.js"),o="function"==typeof Symbol&&Symbol.for,a=o?Symbol.for("react.element"):60103,i=o?Symbol.for("react.portal"):60106,u=o?Symbol.for("react.fragment"):60107,l=o?Symbol.for("react.strict_mode"):60108,c=o?Symbol.for("react.profiler"):60114,s=o?Symbol.for("react.provider"):60109,f=o?Symbol.for("react.context"):60110,p=o?Symbol.for("react.concurrent_mode"):60111,d=o?Symbol.for("react.forward_ref"):60112,m=o?Symbol.for("react.suspense"):60113,y=o?Symbol.for("react.suspense_list"):60120,g=o?Symbol.for("react.memo"):60115,b=o?Symbol.for("react.lazy"):60116,v=o?Symbol.for("react.block"):60121,h=o?Symbol.for("react.fundamental"):60117,w=o?Symbol.for("react.responder"):60118,_=o?Symbol.for("react.scope"):60119,k="function"==typeof Symbol&&Symbol.iterator,S="@@iterator";function C(e){if(null===e||"object"!=typeof e)return null;var t=k&&e[k]||e[S];return"function"==typeof t?t:null}var j={current:null},R={current:null},O=/^(.*)[\\\/]/;var P=1;function E(e){if(null==e)return null;if("number"==typeof e.tag&&M("Received an unexpected object in getComponentName(). This is likely a bug in React. Please file an issue."),"function"==typeof e)return e.displayName||e.name||null;if("string"==typeof e)return e;switch(e){case u:return"Fragment";case i:return"Portal";case c:return"Profiler";case l:return"StrictMode";case m:return"Suspense";case y:return"SuspenseList"}if("object"==typeof e)switch(e.$$typeof){case f:return"Context.Consumer";case s:return"Context.Provider";case d:return function(e,t,n){var r=t.displayName||t.name||"";return e.displayName||(""!==r?n+"("+r+")":n)}(e,e.render,"ForwardRef");case g:return E(e.type);case v:return E(e.render);case b:var t=function(e){return e._status===P?e._result:null}(e);if(t)return E(t)}return null}var x={},$=null;function I(e){$=e}x.getCurrentStack=null,x.getStackAddendum=function(){var e="";if($){var t=E($.type),n=$._owner;e+=function(e,t,n){var r="";if(t){var o=t.fileName,a=o.replace(O,"");if(/^index\./.test(a)){var i=o.match(O);if(i){var u=i[1];u&&(a=u.replace(O,"")+"/"+a)}}r=" (at "+a+":"+t.lineNumber+")"}else n&&(r=" (created by "+n+")");return"\n    in "+(e||"Unknown")+r}(t,$._source,n&&E(n.type))}var r=x.getCurrentStack;return r&&(e+=r()||""),e};var T={ReactCurrentDispatcher:j,ReactCurrentBatchConfig:{suspense:null},ReactCurrentOwner:R,IsSomeRendererActing:{current:!1},assign:e};function H(e){for(var t=arguments.length,n=new Array(t>1?t-1:0),r=1;r<t;r++)n[r-1]=arguments[r];W("warn",e,n)}function M(e){for(var t=arguments.length,n=new Array(t>1?t-1:0),r=1;r<t;r++)n[r-1]=arguments[r];W("error",e,n)}function W(e,t,n){if(!(n.length>0&&"string"==typeof n[n.length-1]&&0===n[n.length-1].indexOf("\n    in"))){var r=T.ReactDebugCurrentFrame.getStackAddendum();""!==r&&(t+="%s",n=n.concat([r]))}var o=n.map(function(e){return""+e});o.unshift("Warning: "+t),Function.prototype.apply.call(console[e],console,o);try{var a=0,i="Warning: "+t.replace(/%s/g,function(){return n[a++]});throw new Error(i)}catch(e){}}e(T,{ReactDebugCurrentFrame:x,ReactComponentTreeHook:{}});var D={};function A(e,t){var n=e.constructor,r=n&&(n.displayName||n.name)||"ReactClass",o=r+"."+t;D[o]||(M("Can't call %s on a component that is not yet mounted. This is a no-op, but it might indicate a bug in your application. Instead, assign to `this.state` directly or define a `state = {};` class property with the desired state in the %s component.",t,r),D[o]=!0)}var U={isMounted:function(e){return!1},enqueueForceUpdate:function(e,t,n){A(e,"forceUpdate")},enqueueReplaceState:function(e,t,n,r){A(e,"replaceState")},enqueueSetState:function(e,t,n,r){A(e,"setState")}},N={};function V(e,t,n){this.props=e,this.context=t,this.refs=N,this.updater=n||U}Object.freeze(N),V.prototype.isReactComponent={},V.prototype.setState=function(e,t){if("object"!=typeof e&&"function"!=typeof e&&null!=e)throw Error("setState(...): takes an object of state variables to update or a function which returns an object of state variables.");this.updater.enqueueSetState(this,e,t,"setState")},V.prototype.forceUpdate=function(e){this.updater.enqueueForceUpdate(this,e,"forceUpdate")};var L={isMounted:["isMounted","Instead, make sure to clean up subscriptions and pending requests in componentWillUnmount to prevent memory leaks."],replaceState:["replaceState","Refactor your code to use setState instead (see https://github.com/facebook/react/issues/3236)."]},F=function(e,t){Object.defineProperty(V.prototype,e,{get:function(){H("%s(...) is deprecated in plain JavaScript React classes. %s",t[0],t[1])}})};for(var B in L)L.hasOwnProperty(B)&&F(B,L[B]);function z(){}function q(e,t,n){this.props=e,this.context=t,this.refs=N,this.updater=n||U}z.prototype=V.prototype;var Y=q.prototype=new z;Y.constructor=q,e(Y,V.prototype),Y.isPureReactComponent=!0;var Z,J,X,G=Object.prototype.hasOwnProperty,K={key:!0,ref:!0,__self:!0,__source:!0};function Q(e){if(G.call(e,"ref")){var t=Object.getOwnPropertyDescriptor(e,"ref").get;if(t&&t.isReactWarning)return!1}return void 0!==e.ref}function ee(e){if(G.call(e,"key")){var t=Object.getOwnPropertyDescriptor(e,"key").get;if(t&&t.isReactWarning)return!1}return void 0!==e.key}X={};var te=function(e,t,n,r,o,i,u){var l={$$typeof:a,type:e,key:t,ref:n,props:u,_owner:i,_store:{}};return Object.defineProperty(l._store,"validated",{configurable:!1,enumerable:!1,writable:!0,value:!1}),Object.defineProperty(l,"_self",{configurable:!1,enumerable:!1,writable:!1,value:r}),Object.defineProperty(l,"_source",{configurable:!1,enumerable:!1,writable:!1,value:o}),Object.freeze&&(Object.freeze(l.props),Object.freeze(l)),l};function ne(e,t,n){var r,o={},a=null,i=null,u=null,l=null;if(null!=t)for(r in Q(t)&&(i=t.ref,function(e){if("string"==typeof e.ref&&R.current&&e.__self&&R.current.stateNode!==e.__self){var t=E(R.current.type);X[t]||(M('Component "%s" contains the string ref "%s". Support for string refs will be removed in a future major release. This case cannot be automatically converted to an arrow function. We ask you to manually fix this case by using useRef() or createRef() instead. Learn more about using refs safely here: https://fb.me/react-strict-mode-string-ref',E(R.current.type),e.ref),X[t]=!0)}}(t)),ee(t)&&(a=""+t.key),u=void 0===t.__self?null:t.__self,l=void 0===t.__source?null:t.__source,t)G.call(t,r)&&!K.hasOwnProperty(r)&&(o[r]=t[r]);var c=arguments.length-2;if(1===c)o.children=n;else if(c>1){for(var s=Array(c),f=0;f<c;f++)s[f]=arguments[f+2];Object.freeze&&Object.freeze(s),o.children=s}if(e&&e.defaultProps){var p=e.defaultProps;for(r in p)void 0===o[r]&&(o[r]=p[r])}if(a||i){var d="function"==typeof e?e.displayName||e.name||"Unknown":e;a&&function(e,t){var n=function(){Z||(Z=!0,M("%s: `key` is not a prop. Trying to access it will result in `undefined` being returned. If you need to access the same value within the child component, you should pass it as a different prop. (https://fb.me/react-special-props)",t))};n.isReactWarning=!0,Object.defineProperty(e,"key",{get:n,configurable:!0})}(o,d),i&&function(e,t){var n=function(){J||(J=!0,M("%s: `ref` is not a prop. Trying to access it will result in `undefined` being returned. If you need to access the same value within the child component, you should pass it as a different prop. (https://fb.me/react-special-props)",t))};n.isReactWarning=!0,Object.defineProperty(e,"ref",{get:n,configurable:!0})}(o,d)}return te(e,a,i,u,l,R.current,o)}function re(e){return"object"==typeof e&&null!==e&&e.$$typeof===a}var oe=".",ae=":";var ie=!1,ue=/\/+/g;function le(e){return(""+e).replace(ue,"$&/")}var ce,se=10,fe=[];function pe(e,t,n,r){if(fe.length){var o=fe.pop();return o.result=e,o.keyPrefix=t,o.func=n,o.context=r,o.count=0,o}return{result:e,keyPrefix:t,func:n,context:r,count:0}}function de(e){e.result=null,e.keyPrefix=null,e.func=null,e.context=null,e.count=0,fe.length<se&&fe.push(e)}function me(e,t,n){return null==e?0:function e(t,n,r,o){var u=typeof t;"undefined"!==u&&"boolean"!==u||(t=null);var l,c=!1;if(null===t)c=!0;else switch(u){case"string":case"number":c=!0;break;case"object":switch(t.$$typeof){case a:case i:c=!0}}if(c)return r(o,t,""===n?oe+ye(t,0):n),1;var s=0,f=""===n?oe:n+ae;if(Array.isArray(t))for(var p=0;p<t.length;p++)s+=e(l=t[p],f+ye(l,p),r,o);else{var d=C(t);if("function"==typeof d){d===t.entries&&(ie||H("Using Maps as children is deprecated and will be removed in a future major release. Consider converting children to an array of keyed ReactElements instead."),ie=!0);for(var m,y=d.call(t),g=0;!(m=y.next()).done;)s+=e(l=m.value,f+ye(l,g++),r,o)}else if("object"===u){var b;b=" If you meant to render a collection of children, use an array instead."+x.getStackAddendum();var v=""+t;throw Error("Objects are not valid as a React child (found: "+("[object Object]"===v?"object with keys {"+Object.keys(t).join(", ")+"}":v)+")."+b)}}return s}(e,"",t,n)}function ye(e,t){return"object"==typeof e&&null!==e&&null!=e.key?function(e){var t={"=":"=0",":":"=2"};return"$"+(""+e).replace(/[=:]/g,function(e){return t[e]})}(e.key):t.toString(36)}function ge(e,t,n){var r=e.func,o=e.context;r.call(o,t,e.count++)}function be(e,t,n){var r=e.result,o=e.keyPrefix,a=e.func,i=e.context,u=a.call(i,t,e.count++);Array.isArray(u)?ve(u,r,n,function(e){return e}):null!=u&&(re(u)&&(u=function(e,t){return te(e.type,t,e.ref,e._self,e._source,e._owner,e.props)}(u,o+(!u.key||t&&t.key===u.key?"":le(u.key)+"/")+n)),r.push(u))}function ve(e,t,n,r,o){var a="";null!=n&&(a=le(n)+"/");var i=pe(t,a,r,o);me(e,be,i),de(i)}function he(e){return"string"==typeof e||"function"==typeof e||e===u||e===p||e===c||e===l||e===m||e===y||"object"==typeof e&&null!==e&&(e.$$typeof===b||e.$$typeof===g||e.$$typeof===s||e.$$typeof===f||e.$$typeof===d||e.$$typeof===h||e.$$typeof===w||e.$$typeof===_||e.$$typeof===v)}function we(){var e=j.current;if(null===e)throw Error("Invalid hook call. Hooks can only be called inside of the body of a function component. This could happen for one of the following reasons:\n1. You might have mismatching versions of React and the renderer (such as React DOM)\n2. You might be breaking the Rules of Hooks\n3. You might have more than one copy of React in the same app\nSee https://fb.me/react-invalid-hook-call for tips about how to debug and fix this problem.");return e}function _e(){if(R.current){var e=E(R.current.type);if(e)return"\n\nCheck the render method of `"+e+"`."}return""}ce=!1;var ke={};function Se(e,t){if(e._store&&!e._store.validated&&null==e.key){e._store.validated=!0;var n=function(e){var t=_e();if(!t){var n="string"==typeof e?e:e.displayName||e.name;n&&(t="\n\nCheck the top-level render call using <"+n+">.")}return t}(t);if(!ke[n]){ke[n]=!0;var r="";e&&e._owner&&e._owner!==R.current&&(r=" It was passed a child from "+E(e._owner.type)+"."),I(e),M('Each child in a list should have a unique "key" prop.%s%s See https://fb.me/react-warning-keys for more information.',n,r),I(null)}}}function Ce(e,t){if("object"==typeof e)if(Array.isArray(e))for(var n=0;n<e.length;n++){var r=e[n];re(r)&&Se(r,t)}else if(re(e))e._store&&(e._store.validated=!0);else if(e){var o=C(e);if("function"==typeof o&&o!==e.entries)for(var a,i=o.call(e);!(a=i.next()).done;)re(a.value)&&Se(a.value,t)}}function je(e){var t=e.type;if(null!==t&&void 0!==t&&"string"!=typeof t){var n,o=E(t);if("function"==typeof t)n=t.propTypes;else{if("object"!=typeof t||t.$$typeof!==d&&t.$$typeof!==g)return;n=t.propTypes}n?(I(e),r(n,e.props,"prop",o,x.getStackAddendum),I(null)):void 0===t.PropTypes||ce||(ce=!0,M("Component %s declared `PropTypes` instead of `propTypes`. Did you misspell the property assignment?",o||"Unknown")),"function"!=typeof t.getDefaultProps||t.getDefaultProps.isReactClassApproved||M("getDefaultProps is only used on classic React.createClass definitions. Use a static property named `defaultProps` instead.")}}function Re(e,t,n){var r=he(e);if(!r){var o="";(void 0===e||"object"==typeof e&&null!==e&&0===Object.keys(e).length)&&(o+=" You likely forgot to export your component from the file it's defined in, or you might have mixed up default and named imports.");var i,l=function(e){return null!==e&&void 0!==e?function(e){return void 0!==e?"\n\nCheck your code at "+e.fileName.replace(/^.*[\\\/]/,"")+":"+e.lineNumber+".":""}(e.__source):""}(t);o+=l||_e(),null===e?i="null":Array.isArray(e)?i="array":void 0!==e&&e.$$typeof===a?(i="<"+(E(e.type)||"Unknown")+" />",o=" Did you accidentally export a JSX literal instead of a component?"):i=typeof e,M("React.createElement: type is invalid -- expected a string (for built-in components) or a class/function (for composite components) but got: %s.%s",i,o)}var c=ne.apply(this,arguments);if(null==c)return c;if(r)for(var s=2;s<arguments.length;s++)Ce(arguments[s],e);return e===u?function(e){I(e);for(var t=Object.keys(e.props),n=0;n<t.length;n++){var r=t[n];if("children"!==r&&"key"!==r){M("Invalid prop `%s` supplied to `React.Fragment`. React.Fragment can only have `key` and `children` props.",r);break}}null!==e.ref&&M("Invalid attribute `ref` supplied to `React.Fragment`."),I(null)}(c):je(c),c}var Oe=!1;try{var Pe=Object.freeze({}),Ee=new Map([[Pe,null]]),xe=new Set([Pe]);Ee.set(0,0),xe.add(0)}catch(e){}var $e=Re,Ie=function(t,n,r){for(var o=function(t,n,r){if(null===t||void 0===t)throw Error("React.cloneElement(...): The argument must be a React element, but you passed "+t+".");var o,a,i=e({},t.props),u=t.key,l=t.ref,c=t._self,s=t._source,f=t._owner;if(null!=n)for(o in Q(n)&&(l=n.ref,f=R.current),ee(n)&&(u=""+n.key),t.type&&t.type.defaultProps&&(a=t.type.defaultProps),n)G.call(n,o)&&!K.hasOwnProperty(o)&&(void 0===n[o]&&void 0!==a?i[o]=a[o]:i[o]=n[o]);var p=arguments.length-2;if(1===p)i.children=r;else if(p>1){for(var d=Array(p),m=0;m<p;m++)d[m]=arguments[m+2];i.children=d}return te(t.type,u,l,c,s,f,i)}.apply(this,arguments),a=2;a<arguments.length;a++)Ce(arguments[a],o.type);return je(o),o},Te=function(e){var t=Re.bind(null,e);return t.type=e,Oe||(Oe=!0,H("React.createFactory() is deprecated and will be removed in a future major release. Consider using JSX or use React.createElement() directly instead.")),Object.defineProperty(t,"type",{enumerable:!1,get:function(){return H("Factory.type is deprecated. Access the class directly before passing it to createFactory."),Object.defineProperty(this,"type",{value:e}),e}}),t},He={map:function(e,t,n){if(null==e)return e;var r=[];return ve(e,r,null,t,n),r},forEach:function(e,t,n){if(null==e)return e;var r=pe(null,null,t,n);me(e,ge,r),de(r)},count:function(e){return me(e,function(){return null},null)},toArray:function(e){var t=[];return ve(e,t,null,function(e){return e}),t},only:function(e){if(!re(e))throw Error("React.Children.only expected to receive a single React element child.");return e}};t.Children=He,t.Component=V,t.Fragment=u,t.Profiler=c,t.PureComponent=q,t.StrictMode=l,t.Suspense=m,t.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED=T,t.cloneElement=Ie,t.createContext=function(e,t){void 0===t?t=null:null!==t&&"function"!=typeof t&&M("createContext: Expected the optional second argument to be a function. Instead received: %s",t);var n={$$typeof:f,_calculateChangedBits:t,_currentValue:e,_currentValue2:e,_threadCount:0,Provider:null,Consumer:null};n.Provider={$$typeof:s,_context:n};var r=!1,o=!1,a={$$typeof:f,_context:n,_calculateChangedBits:n._calculateChangedBits};return Object.defineProperties(a,{Provider:{get:function(){return o||(o=!0,M("Rendering <Context.Consumer.Provider> is not supported and will be removed in a future major release. Did you mean to render <Context.Provider> instead?")),n.Provider},set:function(e){n.Provider=e}},_currentValue:{get:function(){return n._currentValue},set:function(e){n._currentValue=e}},_currentValue2:{get:function(){return n._currentValue2},set:function(e){n._currentValue2=e}},_threadCount:{get:function(){return n._threadCount},set:function(e){n._threadCount=e}},Consumer:{get:function(){return r||(r=!0,M("Rendering <Context.Consumer.Consumer> is not supported and will be removed in a future major release. Did you mean to render <Context.Consumer> instead?")),n.Consumer}}}),n.Consumer=a,n._currentRenderer=null,n._currentRenderer2=null,n},t.createElement=$e,t.createFactory=Te,t.createRef=function(){var e={current:null};return Object.seal(e),e},t.forwardRef=function(e){return null!=e&&e.$$typeof===g?M("forwardRef requires a render function but received a `memo` component. Instead of forwardRef(memo(...)), use memo(forwardRef(...))."):"function"!=typeof e?M("forwardRef requires a render function but was given %s.",null===e?"null":typeof e):0!==e.length&&2!==e.length&&M("forwardRef render functions accept exactly two parameters: props and ref. %s",1===e.length?"Did you forget to use the ref parameter?":"Any additional parameter will be undefined."),null!=e&&(null==e.defaultProps&&null==e.propTypes||M("forwardRef render functions do not support propTypes or defaultProps. Did you accidentally pass a React component?")),{$$typeof:d,render:e}},t.isValidElement=re,t.lazy=function(e){var t,n,r={$$typeof:b,_ctor:e,_status:-1,_result:null};return Object.defineProperties(r,{defaultProps:{configurable:!0,get:function(){return t},set:function(e){M("React.lazy(...): It is not supported to assign `defaultProps` to a lazy component import. Either specify them where the component is defined, or create a wrapping component around it."),t=e,Object.defineProperty(r,"defaultProps",{enumerable:!0})}},propTypes:{configurable:!0,get:function(){return n},set:function(e){M("React.lazy(...): It is not supported to assign `propTypes` to a lazy component import. Either specify them where the component is defined, or create a wrapping component around it."),n=e,Object.defineProperty(r,"propTypes",{enumerable:!0})}}}),r},t.memo=function(e,t){return he(e)||M("memo: The first argument must be a component. Instead received: %s",null===e?"null":typeof e),{$$typeof:g,type:e,compare:void 0===t?null:t}},t.useCallback=function(e,t){return we().useCallback(e,t)},t.useContext=function(e,t){var n=we();if(void 0!==t&&M("useContext() second argument is reserved for future use in React. Passing it is not supported. You passed: %s.%s",t,"number"==typeof t&&Array.isArray(arguments[2])?"\n\nDid you call array.map(useContext)? Calling Hooks inside a loop is not supported. Learn more at https://fb.me/rules-of-hooks":""),void 0!==e._context){var r=e._context;r.Consumer===e?M("Calling useContext(Context.Consumer) is not supported, may cause bugs, and will be removed in a future major release. Did you mean to call useContext(Context) instead?"):r.Provider===e&&M("Calling useContext(Context.Provider) is not supported. Did you mean to call useContext(Context) instead?")}return n.useContext(e,t)},t.useDebugValue=function(e,t){return we().useDebugValue(e,t)},t.useEffect=function(e,t){return we().useEffect(e,t)},t.useImperativeHandle=function(e,t,n){return we().useImperativeHandle(e,t,n)},t.useLayoutEffect=function(e,t){return we().useLayoutEffect(e,t)},t.useMemo=function(e,t){return we().useMemo(e,t)},t.useReducer=function(e,t,n){return we().useReducer(e,t,n)},t.useRef=function(e){return we().useRef(e)},t.useState=function(e){return we().useState(e)},t.version="16.14.0"})()},"./node_modules/react/index.js":function(e,t,n){"use strict";e.exports=n("./node_modules/react/cjs/react.development.js")},"./src/js/admin/image-block.js":function(e,t,n){"use strict";var r=function(e){return e&&e.__esModule?e:{default:e}}(n("./node_modules/react/index.js"));wp.i18n.__;var o=wp.blocks.registerBlockType,a=wp.blockEditor,i=a.useBlockProps,u=a.MediaUploadCheck,l=a.InspectorControls,c=a.MediaUpload,s=wp.components,f=s.Button,p=s.PanelBody,d=s.PanelRow,m=(s.SelectControl,s.TextControl),y=s.ToggleControl,g=wp.serverSideRender,b=wp.element.createElement,v=wp.data.useSelect;o("cw-blocks/responsive-image",{title:"Responsive Image",icon:b("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},b("path",{d:"M7.74,7.74V24H24V7.74Zm13,8-4.91,4.91-2.79-2.82L9.29,21.62V9.29H22.45v8.13Zm-8.84-5.22A1.49,1.49,0,1,1,10.44,12,1.49,1.49,0,0,1,11.93,10.52ZM1.55,22.45V1.55h20.9v1.8H24V0H0V24H3.35V22.45Zm3.87,0v-17h17V7.23H24V3.87H3.87V24H7.23V22.45Z"})),category:"embed",attributes:{imgW:{type:"number",default:1600},imgH:{type:"number",default:1200},imgWMed:{type:"number",default:800},imgHMed:{type:"number",default:600},imgWSmall:{type:"number",default:400},imgHSmall:{type:"number",default:300},crop:{type:"boolean",default:!1},linkURL:{type:"string",default:""},targetBlank:{type:"boolean",default:!1},imgID:{type:"number",default:0}},edit:function(e){e.className;var t=e.setAttributes,n=e.attributes,o=(i.save(),v(function(e){var t=e("core").getEntityRecord;return n.imgID&&t("root","media",n.imgID)},[n.imgID])),a=function(e){t({imgID:e.id})},s=function(){t({imgID:0})};return[r.default.createElement(l,{key:"cwkey-1"},r.default.createElement(p,{title:"Image",initialOpen:!0},r.default.createElement(u,null,r.default.createElement(c,{className:"cw-resp-image wp-admin-cw-resp-image",allowedTypes:["image"],multiple:!1,value:o?o.id:"",onSelect:a,render:function(e){var t=e.open;return o?r.default.createElement(f,{onClick:s,className:"button"},"Remove Image"):r.default.createElement(f,{onClick:t,className:"button"},"Select/Upload Image")}}))),r.default.createElement(p,{title:"URL",initialOpen:!1},r.default.createElement(m,{label:"URL",value:e.attributes.linkURL,onChange:function(e){return t({linkURL:e})},type:"text"}),r.default.createElement(y,{label:"Open link in new tab",checked:e.attributes.targetBlank,onChange:function(e){return t({targetBlank:e})}})),r.default.createElement(p,{title:"Sizes",initialOpen:!0},r.default.createElement(d,null,r.default.createElement("p",null,"Both width and height are required to create a cropped image.")),r.default.createElement(m,{label:"Small Width (phones)",value:e.attributes.imgWSmall,onChange:function(e){return t({imgWSmall:parseInt(e)})},type:"number"}),r.default.createElement(m,{label:"Small Height (phones)",value:e.attributes.imgHSmall,onChange:function(e){return t({imgHSmall:parseInt(e)})},type:"number"}),r.default.createElement(m,{label:"Medium Width (tablets)",value:e.attributes.imgWMed,onChange:function(e){return t({imgWMed:parseInt(e)})},type:"number"}),r.default.createElement(m,{label:"Medium Height (tablets)",value:e.attributes.imgHMed,onChange:function(e){return t({imgHMed:parseInt(e)})},type:"number"}),r.default.createElement(m,{label:"Large Width (desktop)",value:e.attributes.imgW,onChange:function(e){return t({imgW:parseInt(e)})},type:"number"}),r.default.createElement(m,{label:"Large Height (desktop)",value:e.attributes.imgH,onChange:function(e){return t({imgH:parseInt(e)})},type:"number"})),r.default.createElement(p,{title:"Crop",initialOpen:!1},r.default.createElement(y,{label:"Crop",checked:e.attributes.crop,onChange:function(e){return t({crop:e})}}))),r.default.createElement(g,{httpMethod:"POST",block:"cw-blocks/responsive-image",attributes:{imgW:n.imgW?n.imgW:0,imgH:n.imgH?n.imgH:0,imgWMed:n.imgWMed?n.imgWMed:0,imgHMed:n.imgHMed?n.imgHMed:0,imgWSmall:n.imgWSmall?n.imgWSmall:0,imgHSmall:n.imgHSmall?n.imgHSmall:0,crop:n.crop,loading:n.loading,linkURL:n.linkURL,targetBlank:n.targetBlank,imgID:n.imgID},EmptyResponsePlaceholder:function(){return r.default.createElement("div",{class:"cwaddimage"},r.default.createElement(c,{className:"cw-resp-image wp-admin-cw-resp-image",allowedTypes:["image"],multiple:!1,value:o?o.id:"",onSelect:a,render:function(e){var t=e.open;return o?r.default.createElement(f,{onClick:s,className:"button"},"Remove Image"):r.default.createElement(f,{onClick:t,className:"button"},"Select/Upload Image")}}))}})]},save:function(){return null}})}});
//# sourceMappingURL=respimgblock.js.map