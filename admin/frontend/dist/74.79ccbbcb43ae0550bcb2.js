(window.webpackJsonp=window.webpackJsonp||[]).push([[74],{1448:function(e,t,n){"use strict";n.r(t);var r=n(0),a=n(1),i=n(341),l=n(1076),c=(n(1217),n(74));function o(){return(o=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)({}).hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e}).apply(null,arguments)}function u(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var n=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=n){var r,a,i,l,c=[],o=!0,u=!1;try{if(i=(n=n.call(e)).next,0===t){if(Object(n)!==n)return;o=!1}else for(;!(o=(r=i.call(n)).done)&&(c.push(r.value),c.length!==t);o=!0);}catch(e){u=!0,a=e}finally{try{if(!o&&null!=n.return&&(l=n.return(),Object(l)!==l))return}finally{if(u)throw a}}return c}}(e,t)||function(e,t){if(e){if("string"==typeof e)return s(e,t);var n={}.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?s(e,t):void 0}}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function s(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=Array(t);n<t;n++)r[n]=e[n];return r}var b=Object(r.lazy)((function(){return Promise.all([n.e(0),n.e(54)]).then(n.bind(null,1409))})),f=Object(r.lazy)((function(){return Promise.all([n.e(0),n.e(5),n.e(59)]).then(n.bind(null,1428))})),m=Object(r.lazy)((function(){return n.e(53).then(n.bind(null,1420))})),d=Object(r.lazy)((function(){return Promise.all([n.e(0),n.e(73)]).then(n.bind(null,1411))}));t.default=function(e){var t=u(Object(r.useState)(!1),2),n=t[0],s=t[1],g=l.a.getStep(),p=l.a.getCampaignId(),j=l.a.getCampaignData(),y=Object(c.a)().setL2Title;Object(r.useEffect)((function(){y("title"in j?Object(r.createElement)(r.Fragment,null,j.title):"")}),[j]);var O=function(t){switch(t){case 1:return Object(r.createElement)(b,{campaignId:p,setPending:s,isPending:n});case 2:return Object(r.createElement)(f,o({},e,{setPending:s,isPending:n}));case 3:return Object(r.createElement)(m,{setPending:s,isPending:n});case 4:return Object(r.createElement)(d,{setPending:s,isPending:n});default:return Object(r.createElement)(r.Fragment,null,Object(a.__)("There is some error","wp-marketing-automations"))}},h=[{key:1,label:Object(a.__)("Information","wp-marketing-automations"),content:O(1)},{key:2,label:Object(a.__)("Contacts","wp-marketing-automations"),content:O(2)},{key:3,label:Object(a.__)("Content","wp-marketing-automations"),content:O(3)},{key:4,label:Object(a.__)("Review","wp-marketing-automations"),content:O(4)}];return Object(r.createElement)("div",{"data-step":g},Object(r.createElement)(i.a,{steps:h,currentStep:parseInt(g)>0?g:1,isPending:n}))}}}]);