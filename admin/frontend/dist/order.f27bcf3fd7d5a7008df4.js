(window.webpackJsonp=window.webpackJsonp||[]).push([[27],{1081:function(e,t,a){"use strict";var n=a(0),r=a(6),c=a.n(r),l=a(1),i=a(8),o=(a(1087),a(39)),s=a(3);function b(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var a=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=a){var n,r,c,l,i=[],o=!0,s=!1;try{if(c=(a=a.call(e)).next,0===t){if(Object(a)!==a)return;o=!1}else for(;!(o=(n=c.call(a)).done)&&(i.push(n.value),i.length!==t);o=!0);}catch(e){s=!0,r=e}finally{try{if(!o&&null!=a.return&&(l=a.return(),Object(l)!==l))return}finally{if(s)throw r}}return i}}(e,t)||function(e,t){if(e){if("string"==typeof e)return m(e,t);var a={}.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?m(e,t):void 0}}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function m(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,n=Array(t);a<t;a++)n[a]=e[a];return n}t.a=function(e){var t=b(Object(n.useState)(!1),2),a=t[0],r=t[1],m=e.modalContent,u=void 0===m?{}:m,f=e.content,d=e.onPage,p=void 0!==d&&d;return Object(n.createElement)(n.Fragment,null,Object(n.createElement)("div",{className:c()("bwf-upgrade-pro-overlay",{"is-on-page":p}),onClick:function(){p||r(!0)}},p?Object(n.createElement)(o.a,{showHeader:!1,modalContent:u}):Object(n.createElement)(n.Fragment,null,Object(n.createElement)("div",{className:"bwf-king-tag-pro"},Object(n.createElement)(i.a,{icon:"king",size:38,color:"#fff"})),Object(n.createElement)("span",{className:"bwf-mt-8"},f||(Object(s.Ob)()?Object(l.__)("Activate your license to continue using premium features without interruption.","wp-marketing-automations"):Object(l.__)("This feature is locked. To get full access of FunnelKit Automation upgrade to PRO","wp-marketing-automations"))))),Object(n.createElement)(o.b,{isOpen:a,onRequestClose:function(){return r(!1)},modalContent:u}))}},1087:function(e,t,a){},1115:function(e,t,a){"use strict";var n=a(0);a(555);function r(e){return function(e){if(Array.isArray(e))return c(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,t){if(e){if("string"==typeof e)return c(e,t);var a={}.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?c(e,t):void 0}}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function c(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,n=Array(t);a<t;a++)n[a]=e[a];return n}t.a=function(e){var t=e.count,a=void 0===t?5:t,c=e.className,l=void 0===c?"":c;return Object(n.createElement)("div",{className:"bwf-accordion-placeholder ".concat(l)},r(Array(a)).map((function(e,t){return Object(n.createElement)("div",{className:"bwf-mb-16 bwf-c-s-collapsible",key:"bwf-accordion-placeholder__".concat(t),"data-accordion":t},Object(n.createElement)("div",{className:"bwf-placeholder-temp"}),Object(n.createElement)("div",{className:"bwf-placeholder-temp"}))})))}},1168:function(e,t,a){},1237:function(e,t,a){},1468:function(e,t,a){"use strict";a.r(t);var n=a(0),r=a(1),c=a(2),l=a(109),i=a(272),o=(a(1168),a(1115)),s=a(14),b=a(111),m=a(8),u=a(3),f=a(145),d=a(6),p=a.n(d),w=a(54);a(1237);function O(e){return function(e){if(Array.isArray(e))return g(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,t){if(e){if("string"==typeof e)return g(e,t);var a={}.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?g(e,t):void 0}}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function g(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,n=Array(t);a<t;a++)n[a]=e[a];return n}var j=function(e){var t=e.isLoading,a=e.products,l=e.showTitle,i=void 0===l||l,o=e.className,s=e.total,b=void 0===s?0:s,m=e.currency,d=void 0===m?{}:m,g=Object(w.a)(Object(c.isEmpty)(d)?Object(u.sb)():d).formatAmount,j=function(e){return!0},v=[{key:"product",label:Object(r.__)("Product","wp-marketing-automations"),cellClassName:"whitespace-wrap"},{key:"step",label:Object(r.__)("Step","wp-marketing-automations"),cellClassName:""},{key:"amount",label:Object(r.__)("Amount","wp-marketing-automations"),cellClassName:"bwf-t-center"}],y=function(e){var t=g(e.revenue);return"discount"===e.type?"- ".concat(t):t},_=a&&a.length>0?[].concat(O(a.map((function(e){return[{display:Object(n.createElement)(n.Fragment,null,e.name),value:e.name},{display:Object(n.createElement)("div",{className:"bwf-tags bwf-tag-gray"},Object(u.xb)(e.type)),value:e.type},{display:y(e),value:e.revenue}]}))),[[{display:Object(n.createElement)("span",{className:p()("bwf-total")},Object(r.__)("Total","wp-marketing-automations")),value:"total"},{display:"",value:""},{display:Object(n.createElement)("span",{className:p()("bwf-total")},g(b)),value:b}]]):[];return Object(n.createElement)(f.a,{className:p()("bwf-cs__product-table bwf-mt-16",o),title:i&&(t?Object(n.createElement)("div",{className:"bwf-placeholder-temp bwf-h-24 bwf-w-60"}):Object(r.__)("Products","wp-marketing-automations")),rows:_,headers:v,query:{paged:1},rowsPerPage:10,totalRows:4,isLoading:t,onPageChange:function(e,t){return!0},onQueryChange:function(e){return"per_page"!==e?function(){}:j},actions:[],rowHeader:!0,showMenu:!1,emptyMessage:Object(r.__)("No Products","wp-marketing-automations")})},v=a(1081),y=a(334),_=function(){var e=[{type:"icon",data:{class:"bwf-pb-gap",content:Object(n.createElement)(m.a,{icon:"zero-orders",width:"202",height:"151"})}},{type:"content",data:{class:"bwf-heading-1 bwf-pb-10",content:Object(r.__)("No Purchase to show","wp-marketing-automations")}},{type:"content",data:{class:"bwf-heading-2 bwf-pb-gap",content:Object(r.__)("Data will began to show once this contact makes a purchase","wp-marketing-automations")}}];return Object(n.createElement)(y.a,{data:e})},E=a(46);function h(e){return function(e){if(Array.isArray(e))return k(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,t){if(e){if("string"==typeof e)return k(e,t);var a={}.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?k(e,t):void 0}}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function k(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,n=Array(t);a<t;a++)n[a]=e[a];return n}var N=function(){var e,t,a,o,s,f,d,p,w,O,g=l.a.getOrders(),y=l.a.getOrderLoading(),k=l.a.getContactLoading(),N=l.a.getOrdersTotal(),A=l.a.getOrdersOffset(),x=l.a.getOrdersLimit(),S=l.a.getContact(),I=Object(i.a)(),C=parseInt(A)/parseInt(x)+1,P=Math.ceil(parseInt(N)/parseInt(x)),T=function(e){return e.reduce((function(e,t){return"discount"===t.type?e-Number(t.revenue):e+Number(t.revenue)}),0)},L=function(e){return Object(c.isEmpty)(e)?"-":e.map((function(e,t){return Object(n.createElement)("div",{key:t,className:"bwf-tags bwf-tag-gray"},e)}))};return Object(c.isEmpty)(g)?Object(n.createElement)("div",{className:"bwf-empty-order-item"},Object(n.createElement)(_,null)):Object(n.createElement)("div",{className:"bwf-cs-details__wrap bwf-cs-contact-tab-data"},(e=S.wc,a=(t=void 0===e?{}:e).purchased_products,o=void 0===a?[]:a,s=t.purchased_products_cats,f=void 0===s?[]:s,d=t.purchased_products_tags,p=void 0===d?[]:d,w=t.used_coupons,O=void 0===w?[]:w,Object(c.isEmpty)(t)||Object(c.isEmpty)(o)&&Object(c.isEmpty)(f)&&Object(c.isEmpty)(p)&&Object(c.isEmpty)(O)?Object(n.createElement)(n.Fragment,null):Object(n.createElement)("div",{className:"bwf-cs-order-overview bwf-mb-24"},Object(n.createElement)("div",{className:"bwf-heading4-new bwf-mb-16"},Object(r.__)("Overview","wp-marketing-automations")),!Object(c.isEmpty)(o)&&Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item"},Object(n.createElement)("div",{className:"bwf-heading5-new bwf-mb-8"},Object(r.__)("Purchased Product","wp-marketing-automations")),Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item-content"},o.map((function(e,t){if(e.hasOwnProperty("name"))return Object(n.createElement)("a",{className:"bwf-new-tag-UI bwf-link-tag",target:"_blank",href:"post.php?post="+parseInt(e.id)+"&action=edit",key:t,rel:"noreferrer"},Object(E.decodeEntities)(e.name))})))),!Object(c.isEmpty)(f)&&Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item"},Object(n.createElement)("div",{className:"bwf-heading5-new bwf-mb-8"},Object(r.__)("Product Categories","wp-marketing-automations")),Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item-content"},f.map((function(e,t){if(e.hasOwnProperty("name"))return Object(n.createElement)("a",{className:"bwf-new-tag-UI bwf-link-tag",target:"_blank",href:"term.php?taxonomy=product_cat&post_type=product&tag_ID="+e.id,key:t,rel:"noreferrer"},Object(E.decodeEntities)(e.name))})))),!Object(c.isEmpty)(p)&&Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item"},Object(n.createElement)("div",{className:"bwf-heading5-new bwf-mb-8"},Object(r.__)("Product Tags","wp-marketing-automations")),Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item-content"},p.map((function(e,t){if(e.hasOwnProperty("name"))return Object(n.createElement)("a",{className:"bwf-new-tag-UI bwf-link-tag",target:"_blank",href:"term.php?taxonomy=product_tag&post_type=product&tag_ID="+e.id,key:t,rel:"noreferrer"},Object(E.decodeEntities)(e.name))})))),!Object(c.isEmpty)(O)&&Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item"},Object(n.createElement)("div",{className:"bwf-heading5-new bwf-mb-8"},Object(r.__)("Coupon Used","wp-marketing-automations")),Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item-content"},O.map((function(e,t){if(""!==e)return Object(n.createElement)("span",{className:"bwf-new-tag-UI",key:t},Object(E.decodeEntities)(e))})))))),Object(n.createElement)(b.a,{items:null==g?void 0:g.map((function(e,t){var a,l,i,o,s=e.customer_info,b=void 0===s?{}:s,f=e.currency,d=void 0===f?{}:f;return{key:t,label:Object(n.createElement)("div",{className:"bwf_w_full bwf-display-flex bwf-space-between"},Object(n.createElement)("div",{className:"bwf-display-flex bwf--g12"},Object(n.createElement)("span",{className:"bwf-order"},"".concat(Object(r.__)("Order ID:","wp-marketing-automations"),"  ").concat(null==e?void 0:e.order_id)),Object(n.createElement)("div",{onClickCapture:function(e){return e.stopPropagation()}},Object(n.createElement)("a",{target:"_blank",href:"post.php?post=".concat(null==e?void 0:e.order_id,"&action=edit"),className:"bwf-list-btn",rel:"noreferrer"},Object(n.createElement)("span",null,Object(r.__)("View","wp-marketing-automations")),Object(n.createElement)(m.a,{icon:"external-link-2",size:16})))),e.hasOwnProperty("status")?Object(n.createElement)("div",{className:"bwf-tags ".concat((o=e.status.value,"wc-processing"===o?"bwf-tag-green":"wc-on-hold"===o?"bwf-tag-orange":"wc-completed"===o?"bwf-tag-blue":["wc-expired","wc-failed"].includes(o)?"bwf-tag-red":"bwf-tag-gray"))},e.status.label):null),display:Object(n.createElement)(n.Fragment,null,Object(n.createElement)("div",{className:"bwf-display-flex bwf-display-flex-column gap-16 bwf_w_full bwf--align-start"},Object(n.createElement)("div",{className:"bwf-contact-header bwf_w_full bwf-display-flex bwf-flex-start bwf--g8"},Object(n.createElement)("div",{className:"bwf-icon"},Object(n.createElement)(m.a,{icon:"user",width:20,height:20})),Object(n.createElement)("label",null,Object(r.__)("Billing Details","wp-marketing-automations"))),Object(n.createElement)("div",{className:"bwf-contact-info-container"},Object(n.createElement)("div",{className:"bwf-contact-info bwf-repeat-4"},Object(n.createElement)("div",{className:"bwf-display-flex bwf-display-flex-column bwf--align-start bwf-word-break bwf-flex-start"},Object(n.createElement)("label",null,Object(r.__)("Email ID","wp-marketing-automations")),Object(n.createElement)("span",null,null==b?void 0:b.email)),Object(n.createElement)("div",{className:"bwf-display-flex bwf-display-flex-column bwf--align-start bwf-word-break bwf-flex-start"},Object(n.createElement)("label",null,Object(r.__)("Phone","wp-marketing-automations")),Object(n.createElement)("span",null,null!=b&&b.phone?null==b?void 0:b.phone:"-")),Object(n.createElement)("div",{className:"bwf-display-flex bwf-display-flex-column bwf--align-start bwf-word-break bwf-flex-start"},Object(n.createElement)("label",null,Object(r.__)("Purchased On","wp-marketing-automations")),Object(n.createElement)("span",null,null!=b&&b.purchased_on?Object(u.cb)(null==b?void 0:b.purchased_on,!1,!1):"-")),Object(n.createElement)("div",{className:"bwf-display-flex bwf-display-flex-column bwf--align-start bwf-word-break bwf-flex-start"},Object(n.createElement)("label",null,Object(r.__)("Payment Method","wp-marketing-automations")),Object(n.createElement)("span",null,null!=b&&b.payment_method?null==b?void 0:b.payment_method:"-"))),Object(n.createElement)("div",{className:"bwf-contact-info"},Object(n.createElement)("div",{className:"bwf-display-flex bwf-display-flex-column bwf--align-start bwf-word-break bwf-flex-start"},Object(n.createElement)("label",null,Object(r.__)("Billing Address","wp-marketing-automations")),Object(c.isObject)(b)&&!Object(c.isEmpty)(b.billing_address)?Object(n.createElement)("div",{dangerouslySetInnerHTML:{__html:b.billing_address},className:"bwf-address"}):"-"),Object(n.createElement)("div",{className:"bwf-display-flex bwf-display-flex-column bwf--align-start bwf-word-break bwf-flex-start"},Object(n.createElement)("label",null,Object(r.__)("Shipping Address","wp-marketing-automations")),Object(c.isObject)(b)&&!Object(c.isEmpty)(b.shipping_address)?Object(n.createElement)("div",{dangerouslySetInnerHTML:{__html:b.shipping_address},className:"bwf-address"}):"-")))),Object(n.createElement)("div",{className:"bwf-contact-header bwf_w_full bwf-display-flex bwf-flex-start bwf--g8 bwf-mt-36"},Object(n.createElement)("div",{className:"bwf-icon"},Object(n.createElement)(m.a,{icon:"overview",height:20,width:20})),Object(n.createElement)("label",null,Object(r.__)("Orders Details","wp-marketing-automations"))),Object(n.createElement)(j,{products:e.products,isLoading:y||k,total:Object(c.isEmpty)(e.products)?0:T(e.products),showTitle:!1,currency:d,className:"bwf-mt-16"}),Object(n.createElement)("div",{className:"bwf-order-tags"},Object(n.createElement)("div",null,Object(n.createElement)("div",{className:"bwf-heading"},Object(r.__)("Categories","wp-marketing-automations")),Object(n.createElement)("div",{className:"bwf-display-flex gap-8 bwf-flex-start bwf-flex-wrap"},L(null==e?void 0:e.categories))),Object(n.createElement)("div",null,Object(n.createElement)("div",{className:"bwf-heading"},Object(r.__)("Tags","wp-marketing-automations")),Object(n.createElement)("div",{className:"bwf-display-flex gap-8 bwf-flex-start bwf-flex-wrap"},L(null==e?void 0:e.tags))),Object(n.createElement)("div",null,Object(n.createElement)("div",{className:"bwf-heading"},Object(r.__)("Coupon","wp-marketing-automations")),Object(n.createElement)("div",{className:"bwf-display-flex gap-8 bwf-flex-start bwf-flex-wrap"},L(null==e?void 0:e.coupons)))),Object(n.createElement)("div",{className:"bwf-contact-header bwf_w_full bwf-display-flex bwf-flex-start bwf--g8 bwf-mt-36"},Object(n.createElement)("div",{className:"bwf-icon"},Object(n.createElement)(m.a,{icon:"insights",height:20,width:20})),Object(n.createElement)("label",null,Object(r.__)("Insights","wp-marketing-automations"))),Object(n.createElement)("div",{className:"bwf-contact-info bwf-position-relative bwf-repeat-4 bwf-mt-16"},!Object(u.Sb)()&&Object(n.createElement)(v.a,{modalContent:{isFeature:!0,featureTitle:Object(r.__)("Order Insights","wp-marketing-automations"),proLink:Object(u.ab)("upgrade",{utm_medium:"Contact+Order+Insights+Upgrade+Modal"})},content:Object(r.__)("We're sorry, this feature is not available on your plan. Learn more Order Insights.","wp-marketing-automations")}),(a=e,l=a.conversion,i=a.campaign,[].concat(h([{label:Object(r.__)("Funnel Name","wp-marketing-automations"),value:null!=l&&l.funnel_title?Object(n.createElement)("span",{onClick:function(){return getHistory().push(null==l?void 0:l.funnel_link)},className:"bwf-external-link bwf-cursor-pointer",target:"__blank"},Object(n.createElement)("span",{className:"bwf-link"},null==l?void 0:l.funnel_title)):"-"}]),[{label:Object(r.__)("Device","wp-marketing-automations"),value:null==l?void 0:l.device},{label:Object(r.__)("Browser","wp-marketing-automations"),value:null==l?void 0:l.browser},{label:Object(r.__)("Country","wp-marketing-automations"),value:null==l?void 0:l.country},{label:Object(r.__)("UTM Name","wp-marketing-automations"),value:null==i?void 0:i.name},{label:Object(r.__)("UTM Source","wp-marketing-automations"),value:null==i?void 0:i.source},{label:Object(r.__)("UTM Medium","wp-marketing-automations"),value:null==i?void 0:i.medium},{label:Object(r.__)("UTM Term","wp-marketing-automations"),value:null==i?void 0:i.term},{label:Object(r.__)("Refer","wp-marketing-automations"),value:null==l?void 0:l.referrer},{label:Object(r.__)("First Click","wp-marketing-automations"),value:Object(c.size)(null==l?void 0:l.first_click)?Object(u.cb)(null==l?void 0:l.first_click,!1,!1):"-"}])).map((function(e,t){return Object(n.createElement)("div",{className:"bwf-display-flex bwf-display-flex-column bwf--align-start bwf-word-break bwf-flex-start",key:"bwf-cs-conversion-data__".concat(t)},Object(n.createElement)("label",null,e.label),Object(n.createElement)("div",{className:"bwf-cs-additional-info__value"},e.value?e.value:"-"))}))))}})),handleIcons:"up-down",className:"bwf-accordion bwf-mb-16"}),parseInt(N)>0&&!(1===P&&1===C)&&Object(n.createElement)("div",{className:"bwf-accordian-footer bwf-mt-16"},Object(n.createElement)("div",{className:"bwf-accordian-footer-item "+(C>1?"":"is-disabled"),onClick:function(){if(C>1){var e=(C-1)*x-x;I.fetchOrders(parseInt(S.id),e,x)}}},Object(n.createElement)(m.a,{icon:"arrow-back",size:12,color:C>1?"#0073AA":"#82838E"}),Object(n.createElement)("span",null,Object(r.__)("Previous","wp-marketing-automations"))),Object(n.createElement)("div",{className:"bwf-accordian-footer-item "+(P>C?"":"is-disabled"),onClick:function(){if(P>C){var e=C*x;I.fetchOrders(parseInt(S.id),e,x)}}},Object(n.createElement)("span",null,Object(r.__)("Next","wp-marketing-automations")),Object(n.createElement)(m.a,{icon:"arrow-forward",size:12,color:P>C?"#0073AA":"#82838E"}))))},A=a(148),x=a(98);function S(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var a=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=a){var n,r,c,l,i=[],o=!0,s=!1;try{if(c=(a=a.call(e)).next,0===t){if(Object(a)!==a)return;o=!1}else for(;!(o=(n=c.call(a)).done)&&(i.push(n.value),i.length!==t);o=!0);}catch(e){s=!0,r=e}finally{try{if(!o&&null!=a.return&&(l=a.return(),Object(l)!==l))return}finally{if(s)throw r}}return i}}(e,t)||function(e,t){if(e){if("string"==typeof e)return I(e,t);var a={}.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?I(e,t):void 0}}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function I(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,n=Array(t);a<t;a++)n[a]=e[a];return n}var C=function(){var e=Object(w.a)(Object(u.sb)()).formatAmount,t=l.a.getContact(),a=p()("bwfcrm-contacts-orders",{"has-search":!0}),o=l.a.getSubscriptions(),s=l.a.getSubscriptionLoading(),b=l.a.getContactLoading(),m=l.a.getOrdersLimit(),d=l.a.getSubscriptionPage(),O=l.a.getSubscriptionsLimit(),g=l.a.getSubscriptionsTotal(),j=Object(i.a)(),v=function(e){switch(e.replace(" ","").toLowerCase()){case"expired":return"danger";case"active":return"success";case"cancelled":case"onhold":case"pendingcancellation":return"warning";default:return""}},y=Object(c.isArray)(o)?o.map((function(t){return r="subscription",b=[{display:(a=t).date?Object(u.cb)(a.date):"-",value:""},{display:Object(n.createElement)("a",{className:"bwf-a-no-underline",target:"_blank",href:"post.php?post="+a.id+"&action=edit",rel:"noreferrer"},"#"+a.id),value:""}],"subscription"==r&&b.push({display:a.next_renewal_date?Object(u.cb)(a.next_renewal_date):"-",value:""}),b.push({display:a.status?(l=a.status,Object(n.createElement)(x.b,{content:l,type:v(l)})):"-",value:""}),"subscription"==r&&b.push({display:a.total_renewal?a.total_renewal:"0",value:""}),"order"===r&&b.push({display:(i=a.items?a.items:[],o="",s=[],Object.entries(i).map((function(e){var t=S(e,2),a=t[0],r=t[1];Object(c.isEmpty)(o)&&(o=Object(n.createElement)("a",{className:"bwf-a-no-underline",target:"_blank",href:"post.php?action=edit&post="+a,rel:"noreferrer"},r)),s.push(Object(n.createElement)("a",{className:"bwf-a-no-underline",target:"_blank",href:"post.php?action=edit&post="+a,rel:"noreferrer"},r))})),Object(n.createElement)(n.Fragment,null,!Object(c.isEmpty)(o)&&o,!Object(c.isEmpty)(s)&&s.length>1&&Object(n.createElement)(A.a,{items:s}))),value:""}),b.push({display:Object(n.createElement)(n.Fragment,null,a.hasOwnProperty("total")&&parseFloat(a.total)>0?Object(n.createElement)("span",{className:"bwf-tags bwf-tag-green"},e(a.total)):"-"),value:""}),b;var a,r,l,i,o,s,b})):[],_=[{key:"date",label:Object(r.__)("Created On","wp-marketing-automations"),isLeftAligned:!0},{key:"sub_id",label:Object(r.__)("Subscription ID","wp-marketing-automations"),isLeftAligned:!1},{key:"renew_date",label:Object(r.__)("Next Renewal Date","wp-marketing-automations"),isLeftAligned:!1},{key:"status",label:Object(r.__)("Status","wp-marketing-automations"),isLeftAligned:!1},{key:"total_renewals",label:Object(r.__)("Total Renewal","wp-marketing-automations"),isLeftAligned:!1},{key:"total",label:Object(r.__)("Total","wp-marketing-automations"),isLeftAligned:!1}],E=function(e){e!==O&&j.fetchSubscription(parseInt(t.id),0,e)};return Object(n.createElement)(f.a,{className:a,hideHeader:"yes",rows:y,headers:_,query:{paged:d},rowsPerPage:O,totalRows:g,isLoading:s||b,showMenu:!1,onPageChange:function(e){return a=(e-1)*m,void j.fetchSubscription(parseInt(t.id),a,O);var a},onQueryChange:function(e){return"per_page"!==e?function(){}:E},emptyMessage:Object(r.__)("No subscriptions found","wp-marketing-automations")})},P=a(13);function T(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var a=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=a){var n,r,c,l,i=[],o=!0,s=!1;try{if(c=(a=a.call(e)).next,0===t){if(Object(a)!==a)return;o=!1}else for(;!(o=(n=c.call(a)).done)&&(i.push(n.value),i.length!==t);o=!0);}catch(e){s=!0,r=e}finally{try{if(!o&&null!=a.return&&(l=a.return(),Object(l)!==l))return}finally{if(s)throw r}}return i}}(e,t)||function(e,t){if(e){if("string"==typeof e)return L(e,t);var a={}.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?L(e,t):void 0}}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function L(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,n=Array(t);a<t;a++)n[a]=e[a];return n}t.default=function(e){var t=e.subtab,a=void 0===t?"orders":t,b=Object(i.a)(),m=l.a.getContact(),u=l.a.getOrderContactId(),f=l.a.getSubscriptions(),d=l.a.getSubscriptionsLimit(),p=l.a.getSubscriptionsOffset(),w=T(Object(n.useState)(""),2),O=w[0],g=w[1];Object(n.useEffect)((function(){g(a||"orders")}),[a]),Object(n.useEffect)((function(){m&&"id"in m&&parseInt(m.id)!==parseInt(u)&&(b.fetchOrders(parseInt(m.id),y,_),b.resetSubscriptionData(),m&&!Object(c.isEmpty)(m.wcs)&&b.fetchSubscription(parseInt(m.id),p,d))}),[m]);var j=l.a.getContactLoading(),v=l.a.getOrderLoading(),y=l.a.getOrdersOffset(),_=l.a.getOrdersLimit();return Object(n.createElement)(n.Fragment,null,!m||Object(c.isEmpty)(m.wcs)||Object(c.isEmpty)(f)?null:Object(n.createElement)("div",{className:"bwf-display-flex gap-8 bwf-flex-start bwf-funnel-buttons bwf-mb-16"},Object(n.createElement)(s.a,{isSecondary:!O||"orders"===O,isTertiary:O&&"orders"!==O,onClick:function(){Object(P.k)({page:"autonami",path:"/contact/".concat(m.id,"/purchase")},"/",{})},className:"bwf-btn-small "+(O&&"orders"!==O?"":"is-border is-blue-bg")},Object(r.__)("Orders","wp-marketing-automations")),Object(n.createElement)(s.a,{isSecondary:O&&"subscription"===O,isTertiary:O&&"subscription"!==O,onClick:function(){Object(P.k)({page:"autonami",path:"/contact/".concat(m.id,"/purchase/subscription")},"/",{})},className:"bwf-btn-small "+(O&&"subscription"===O?"is-border is-blue-bg":"")},Object(r.__)("Subscription","wp-marketing-automations"))),v||j?Object(n.createElement)(n.Fragment,null,Object(n.createElement)("div",{className:"bwf-cs-order-overview bwf-mb-24"},Object(n.createElement)("div",{className:"bwf-heading4-new bwf-mb-16"},Object(n.createElement)("div",{className:"bwf-placeholder-temp bwf-w-120 bwf-h-30"})),[1,2,3].map((function(e){return Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item",key:e},Object(n.createElement)("div",{className:"bwf-heading5-new bwf-mb-8"},Object(n.createElement)("div",{className:"bwf-placeholder-temp bwf-w-120 bwf-h-20"})),Object(n.createElement)("div",{className:"bwf-cs-oder-overview-item-content"},[0,1,2,3,4,5].map((function(e){return Object(n.createElement)("span",{className:"bwf-placeholder-temp bwf-h-20 bwf-w-60 bwf-mr-10 bwf-border-radius-23",key:e})}))))}))),Object(n.createElement)(o.a,null)):"subscription"===O&&m&&!Object(c.isEmpty)(m.wcs)?Object(n.createElement)(C,null):Object(n.createElement)(N,null))}}}]);