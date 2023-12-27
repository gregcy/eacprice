<!DOCTYPE html>
<html>

<head>
  <meta charset="utf8" />
  <title>Cyprus Electricity cost API</title>
  <!-- needed for adaptive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      padding: 0;
      margin: 0;
    }
  </style>
  <script src="https://cdn.redoc.ly/redoc/v2.1.3/bundles/redoc.standalone.js"></script><style data-styled="true" data-styled-version="6.1.1">.gvoNGN{width:calc(100% - 40%);padding:0 40px;}/*!sc*/
@media print,screen and (max-width: 75rem){.gvoNGN{width:100%;padding:40px 40px;}}/*!sc*/
data-styled.g4[id="sc-hKgKIp"]{content:"gvoNGN,"}/*!sc*/
.kxmVZO{padding:40px 0;}/*!sc*/
.kxmVZO:last-child{min-height:calc(100vh + 1px);}/*!sc*/
.kxmVZO>.kxmVZO:last-child{min-height:initial;}/*!sc*/
@media print,screen and (max-width: 75rem){.kxmVZO{padding:0;}}/*!sc*/
.bCpIRB{padding:40px 0;position:relative;}/*!sc*/
.bCpIRB:last-child{min-height:calc(100vh + 1px);}/*!sc*/
.bCpIRB>.bCpIRB:last-child{min-height:initial;}/*!sc*/
@media print,screen and (max-width: 75rem){.bCpIRB{padding:0;}}/*!sc*/
.bCpIRB:not(:last-of-type):after{position:absolute;bottom:0;width:100%;display:block;content:'';border-bottom:1px solid rgba(0, 0, 0, 0.2);}/*!sc*/
data-styled.g5[id="sc-eCstZk"]{content:"kxmVZO,bCpIRB,"}/*!sc*/
.QymcT{width:40%;color:#ffffff;background-color:#263238;padding:0 40px;}/*!sc*/
@media print,screen and (max-width: 75rem){.QymcT{width:100%;padding:40px 40px;}}/*!sc*/
data-styled.g6[id="sc-jSguLX"]{content:"QymcT,"}/*!sc*/
.bZqtR{background-color:#263238;}/*!sc*/
data-styled.g7[id="sc-gKsecS"]{content:"bZqtR,"}/*!sc*/
.keMybc{display:flex;width:100%;padding:0;}/*!sc*/
@media print,screen and (max-width: 75rem){.keMybc{flex-direction:column;}}/*!sc*/
data-styled.g8[id="sc-iBPTVF"]{content:"keMybc,"}/*!sc*/
.djltfY{font-family:Montserrat,sans-serif;font-weight:400;font-size:1.85714em;line-height:1.6em;color:#333333;}/*!sc*/
data-styled.g9[id="sc-fubDmA"]{content:"djltfY,"}/*!sc*/
.biKwui{font-family:Montserrat,sans-serif;font-weight:400;font-size:1.57143em;line-height:1.6em;color:#333333;margin:0 0 20px;}/*!sc*/
data-styled.g10[id="sc-pGaPU"]{content:"biKwui,"}/*!sc*/
.jmifsN{color:#ffffff;}/*!sc*/
data-styled.g12[id="sc-kEjbdu"]{content:"jmifsN,"}/*!sc*/
.bRzaSI{border-bottom:1px solid rgba(38, 50, 56, 0.3);margin:1em 0 1em 0;color:rgba(38, 50, 56, 0.5);font-weight:normal;text-transform:uppercase;font-size:0.929em;line-height:20px;}/*!sc*/
data-styled.g13[id="sc-iqHXzD"]{content:"bRzaSI,"}/*!sc*/
.sc-crrtmM{cursor:pointer;margin-left:-20px;padding:0;line-height:1;width:20px;display:inline-block;outline:0;}/*!sc*/
.jGBpue:before{content:'';width:15px;height:15px;background-size:contain;background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeD0iMCIgeT0iMCIgd2lkdGg9IjUxMiIgaGVpZ2h0PSI1MTIiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cGF0aCBmaWxsPSIjMDEwMTAxIiBkPSJNNDU5LjcgMjMzLjRsLTkwLjUgOTAuNWMtNTAgNTAtMTMxIDUwLTE4MSAwIC03LjktNy44LTE0LTE2LjctMTkuNC0yNS44bDQyLjEtNDIuMWMyLTIgNC41LTMuMiA2LjgtNC41IDIuOSA5LjkgOCAxOS4zIDE1LjggMjcuMiAyNSAyNSA2NS42IDI0LjkgOTAuNSAwbDkwLjUtOTAuNWMyNS0yNSAyNS02NS42IDAtOTAuNSAtMjQuOS0yNS02NS41LTI1LTkwLjUgMGwtMzIuMiAzMi4yYy0yNi4xLTEwLjItNTQuMi0xMi45LTgxLjYtOC45bDY4LjYtNjguNmM1MC01MCAxMzEtNTAgMTgxIDBDNTA5LjYgMTAyLjMgNTA5LjYgMTgzLjQgNDU5LjcgMjMzLjR6TTIyMC4zIDM4Mi4ybC0zMi4yIDMyLjJjLTI1IDI0LjktNjUuNiAyNC45LTkwLjUgMCAtMjUtMjUtMjUtNjUuNiAwLTkwLjVsOTAuNS05MC41YzI1LTI1IDY1LjUtMjUgOTAuNSAwIDcuOCA3LjggMTIuOSAxNy4yIDE1LjggMjcuMSAyLjQtMS40IDQuOC0yLjUgNi44LTQuNWw0Mi4xLTQyYy01LjQtOS4yLTExLjYtMTgtMTkuNC0yNS44IC01MC01MC0xMzEtNTAtMTgxIDBsLTkwLjUgOTAuNWMtNTAgNTAtNTAgMTMxIDAgMTgxIDUwIDUwIDEzMSA1MCAxODEgMGw2OC42LTY4LjZDMjc0LjYgMzk1LjEgMjQ2LjQgMzkyLjMgMjIwLjMgMzgyLjJ6Ii8+PC9zdmc+Cg==');opacity:0.5;visibility:hidden;display:inline-block;vertical-align:middle;}/*!sc*/
h1:hover>.jGBpue::before,h2:hover>.jGBpue::before,.jGBpue:hover::before{visibility:visible;}/*!sc*/
data-styled.g14[id="sc-crrtmM"]{content:"jGBpue,"}/*!sc*/
.hHbBnT{height:20px;width:20px;min-width:20px;vertical-align:middle;float:right;transition:transform 0.2s ease-out;transform:rotateZ(0);}/*!sc*/
.hHbBnT polygon{fill:white;}/*!sc*/
data-styled.g15[id="sc-dQpIV"]{content:"hHbBnT,"}/*!sc*/
.gPUvwc{border-left:1px solid #7c7cbb;box-sizing:border-box;position:relative;padding:10px 10px 10px 0;}/*!sc*/
@media screen and (max-width: 50rem){.gPUvwc{display:block;overflow:hidden;}}/*!sc*/
tr:first-of-type>.gPUvwc,tr.last>.gPUvwc{border-left-width:0;background-position:top left;background-repeat:no-repeat;background-size:1px 100%;}/*!sc*/
tr:first-of-type>.gPUvwc{background-image:linear-gradient(
      to bottom,
      transparent 0%,
      transparent 22px,
      #7c7cbb 22px,
      #7c7cbb 100%
    );}/*!sc*/
tr.last>.gPUvwc{background-image:linear-gradient(
      to bottom,
      #7c7cbb 0%,
      #7c7cbb 22px,
      transparent 22px,
      transparent 100%
    );}/*!sc*/
tr.last+tr>.gPUvwc{border-left-color:transparent;}/*!sc*/
tr.last:first-child>.gPUvwc{background:none;border-left-color:transparent;}/*!sc*/
data-styled.g18[id="sc-hBEZvw"]{content:"gPUvwc,"}/*!sc*/
.gXIfsF{vertical-align:top;line-height:20px;white-space:nowrap;font-size:13px;font-family:Courier,monospace;}/*!sc*/
.gXIfsF.deprecated{text-decoration:line-through;color:#707070;}/*!sc*/
data-styled.g20[id="sc-fFubCH"]{content:"gXIfsF,"}/*!sc*/
.kMAhqG{border-bottom:1px solid #9fb4be;padding:10px 0;width:75%;box-sizing:border-box;}/*!sc*/
tr.expanded .kMAhqG{border-bottom:none;}/*!sc*/
@media screen and (max-width: 50rem){.kMAhqG{padding:0 20px;border-bottom:none;border-left:1px solid #7c7cbb;}tr.last>.kMAhqG{border-left:none;}}/*!sc*/
data-styled.g21[id="sc-bkzXAi"]{content:"kMAhqG,"}/*!sc*/
.jwsifT{color:#7c7cbb;font-family:Courier,monospace;margin-right:10px;}/*!sc*/
.jwsifT::before{content:'';display:inline-block;vertical-align:middle;width:10px;height:1px;background:#7c7cbb;}/*!sc*/
.jwsifT::after{content:'';display:inline-block;vertical-align:middle;width:1px;background:#7c7cbb;height:7px;}/*!sc*/
data-styled.g22[id="sc-idOjMB"]{content:"jwsifT,"}/*!sc*/
.buUaAP{border-collapse:separate;border-radius:3px;font-size:14px;border-spacing:0;width:100%;}/*!sc*/
.buUaAP >tr{vertical-align:middle;}/*!sc*/
@media screen and (max-width: 50rem){.buUaAP{display:block;}.buUaAP >tr,.buUaAP >tbody>tr{display:block;}}/*!sc*/
@media screen and (max-width: 50rem) and (-ms-high-contrast:none){.buUaAP td{float:left;width:100%;}}/*!sc*/
.buUaAP .sc-dIUfKc,.buUaAP .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc,.buUaAP .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc{margin:1em;margin-right:0;background:#fafafa;}/*!sc*/
.buUaAP .sc-dIUfKc .sc-dIUfKc,.buUaAP .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc,.buUaAP .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc .sc-dIUfKc{background:#ffffff;}/*!sc*/
data-styled.g24[id="sc-hHftZz"]{content:"buUaAP,"}/*!sc*/
.jVRsAZ >ul{list-style:none;padding:0;margin:0;margin:0 -5px;}/*!sc*/
.jVRsAZ >ul >li{padding:5px 10px;display:inline-block;background-color:#11171a;border-bottom:1px solid rgba(0, 0, 0, 0.5);cursor:pointer;text-align:center;outline:none;color:#ccc;margin:0 5px 5px 5px;border:1px solid #07090b;border-radius:5px;min-width:60px;font-size:0.9em;font-weight:bold;}/*!sc*/
.jVRsAZ >ul >li.react-tabs__tab--selected{color:#333333;background:#ffffff;}/*!sc*/
.jVRsAZ >ul >li.react-tabs__tab--selected:focus{outline:auto;}/*!sc*/
.jVRsAZ >ul >li:only-child{flex:none;min-width:100px;}/*!sc*/
.jVRsAZ >ul >li.tab-success{color:#1d8127;}/*!sc*/
.jVRsAZ >ul >li.tab-redirect{color:#ffa500;}/*!sc*/
.jVRsAZ >ul >li.tab-info{color:#87ceeb;}/*!sc*/
.jVRsAZ >ul >li.tab-error{color:#d41f1c;}/*!sc*/
.jVRsAZ >.react-tabs__tab-panel{background:#11171a;}/*!sc*/
.jVRsAZ >.react-tabs__tab-panel>div,.jVRsAZ >.react-tabs__tab-panel>pre{padding:20px;margin:0;}/*!sc*/
.jVRsAZ >.react-tabs__tab-panel>div>pre{padding:0;}/*!sc*/
data-styled.g30[id="sc-cxFKTC"]{content:"jVRsAZ,"}/*!sc*/
.gpkGbA code[class*='language-'],.gpkGbA pre[class*='language-']{text-shadow:0 -0.1em 0.2em black;text-align:left;white-space:pre;word-spacing:normal;word-break:normal;word-wrap:normal;line-height:1.5;-moz-tab-size:4;-o-tab-size:4;tab-size:4;-webkit-hyphens:none;-moz-hyphens:none;-ms-hyphens:none;hyphens:none;}/*!sc*/
@media print{.gpkGbA code[class*='language-'],.gpkGbA pre[class*='language-']{text-shadow:none;}}/*!sc*/
.gpkGbA pre[class*='language-']{padding:1em;margin:0.5em 0;overflow:auto;}/*!sc*/
.gpkGbA .token.comment,.gpkGbA .token.prolog,.gpkGbA .token.doctype,.gpkGbA .token.cdata{color:hsl(30, 20%, 50%);}/*!sc*/
.gpkGbA .token.punctuation{opacity:0.7;}/*!sc*/
.gpkGbA .namespace{opacity:0.7;}/*!sc*/
.gpkGbA .token.property,.gpkGbA .token.tag,.gpkGbA .token.number,.gpkGbA .token.constant,.gpkGbA .token.symbol{color:#4a8bb3;}/*!sc*/
.gpkGbA .token.boolean{color:#e64441;}/*!sc*/
.gpkGbA .token.selector,.gpkGbA .token.attr-name,.gpkGbA .token.string,.gpkGbA .token.char,.gpkGbA .token.builtin,.gpkGbA .token.inserted{color:#a0fbaa;}/*!sc*/
.gpkGbA .token.selector+a,.gpkGbA .token.attr-name+a,.gpkGbA .token.string+a,.gpkGbA .token.char+a,.gpkGbA .token.builtin+a,.gpkGbA .token.inserted+a,.gpkGbA .token.selector+a:visited,.gpkGbA .token.attr-name+a:visited,.gpkGbA .token.string+a:visited,.gpkGbA .token.char+a:visited,.gpkGbA .token.builtin+a:visited,.gpkGbA .token.inserted+a:visited{color:#4ed2ba;text-decoration:underline;}/*!sc*/
.gpkGbA .token.property.string{color:white;}/*!sc*/
.gpkGbA .token.operator,.gpkGbA .token.entity,.gpkGbA .token.url,.gpkGbA .token.variable{color:hsl(40, 90%, 60%);}/*!sc*/
.gpkGbA .token.atrule,.gpkGbA .token.attr-value,.gpkGbA .token.keyword{color:hsl(350, 40%, 70%);}/*!sc*/
.gpkGbA .token.regex,.gpkGbA .token.important{color:#e90;}/*!sc*/
.gpkGbA .token.important,.gpkGbA .token.bold{font-weight:bold;}/*!sc*/
.gpkGbA .token.italic{font-style:italic;}/*!sc*/
.gpkGbA .token.entity{cursor:help;}/*!sc*/
.gpkGbA .token.deleted{color:red;}/*!sc*/
data-styled.g32[id="sc-iJuWdM"]{content:"gpkGbA,"}/*!sc*/
.bIDavi{opacity:0.7;transition:opacity 0.3s ease;text-align:right;}/*!sc*/
.bIDavi:focus-within{opacity:1;}/*!sc*/
.bIDavi >button{background-color:transparent;border:0;color:inherit;padding:2px 10px;font-family:Roboto,sans-serif;font-size:14px;line-height:1.5em;cursor:pointer;outline:0;}/*!sc*/
.bIDavi >button :hover,.bIDavi >button :focus{background:rgba(255, 255, 255, 0.1);}/*!sc*/
data-styled.g33[id="sc-giInvV"]{content:"bIDavi,"}/*!sc*/
.eJckYb{position:relative;}/*!sc*/
data-styled.g37[id="sc-kLgoAE"]{content:"eJckYb,"}/*!sc*/
.casAkG{font-family:Roboto,sans-serif;font-weight:400;line-height:1.5em;}/*!sc*/
.casAkG p:last-child{margin-bottom:0;}/*!sc*/
.casAkG h1{font-family:Montserrat,sans-serif;font-weight:400;font-size:1.85714em;line-height:1.6em;color:#32329f;margin-top:0;}/*!sc*/
.casAkG h2{font-family:Montserrat,sans-serif;font-weight:400;font-size:1.57143em;line-height:1.6em;color:#333333;}/*!sc*/
.casAkG code{color:#e53935;background-color:rgba(38, 50, 56, 0.05);font-family:Courier,monospace;border-radius:2px;border:1px solid rgba(38, 50, 56, 0.1);padding:0 5px;font-size:13px;font-weight:400;word-break:break-word;}/*!sc*/
.casAkG pre{font-family:Courier,monospace;white-space:pre;background-color:#11171a;color:white;padding:20px;overflow-x:auto;line-height:normal;border-radius:0;border:1px solid rgba(38, 50, 56, 0.1);}/*!sc*/
.casAkG pre code{background-color:transparent;color:white;padding:0;}/*!sc*/
.casAkG pre code:before,.casAkG pre code:after{content:none;}/*!sc*/
.casAkG blockquote{margin:0;margin-bottom:1em;padding:0 15px;color:#777;border-left:4px solid #ddd;}/*!sc*/
.casAkG img{max-width:100%;box-sizing:content-box;}/*!sc*/
.casAkG ul,.casAkG ol{padding-left:2em;margin:0;margin-bottom:1em;}/*!sc*/
.casAkG ul ul,.casAkG ol ul,.casAkG ul ol,.casAkG ol ol{margin-bottom:0;margin-top:0;}/*!sc*/
.casAkG table{display:block;width:100%;overflow:auto;word-break:normal;word-break:keep-all;border-collapse:collapse;border-spacing:0;margin-top:1.5em;margin-bottom:1.5em;}/*!sc*/
.casAkG table tr{background-color:#fff;border-top:1px solid #ccc;}/*!sc*/
.casAkG table tr:nth-child(2n){background-color:#fafafa;}/*!sc*/
.casAkG table th,.casAkG table td{padding:6px 13px;border:1px solid #ddd;}/*!sc*/
.casAkG table th{text-align:left;font-weight:bold;}/*!sc*/
.casAkG .share-link{cursor:pointer;margin-left:-20px;padding:0;line-height:1;width:20px;display:inline-block;outline:0;}/*!sc*/
.casAkG .share-link:before{content:'';width:15px;height:15px;background-size:contain;background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeD0iMCIgeT0iMCIgd2lkdGg9IjUxMiIgaGVpZ2h0PSI1MTIiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cGF0aCBmaWxsPSIjMDEwMTAxIiBkPSJNNDU5LjcgMjMzLjRsLTkwLjUgOTAuNWMtNTAgNTAtMTMxIDUwLTE4MSAwIC03LjktNy44LTE0LTE2LjctMTkuNC0yNS44bDQyLjEtNDIuMWMyLTIgNC41LTMuMiA2LjgtNC41IDIuOSA5LjkgOCAxOS4zIDE1LjggMjcuMiAyNSAyNSA2NS42IDI0LjkgOTAuNSAwbDkwLjUtOTAuNWMyNS0yNSAyNS02NS42IDAtOTAuNSAtMjQuOS0yNS02NS41LTI1LTkwLjUgMGwtMzIuMiAzMi4yYy0yNi4xLTEwLjItNTQuMi0xMi45LTgxLjYtOC45bDY4LjYtNjguNmM1MC01MCAxMzEtNTAgMTgxIDBDNTA5LjYgMTAyLjMgNTA5LjYgMTgzLjQgNDU5LjcgMjMzLjR6TTIyMC4zIDM4Mi4ybC0zMi4yIDMyLjJjLTI1IDI0LjktNjUuNiAyNC45LTkwLjUgMCAtMjUtMjUtMjUtNjUuNiAwLTkwLjVsOTAuNS05MC41YzI1LTI1IDY1LjUtMjUgOTAuNSAwIDcuOCA3LjggMTIuOSAxNy4yIDE1LjggMjcuMSAyLjQtMS40IDQuOC0yLjUgNi44LTQuNWw0Mi4xLTQyYy01LjQtOS4yLTExLjYtMTgtMTkuNC0yNS44IC01MC01MC0xMzEtNTAtMTgxIDBsLTkwLjUgOTAuNWMtNTAgNTAtNTAgMTMxIDAgMTgxIDUwIDUwIDEzMSA1MCAxODEgMGw2OC42LTY4LjZDMjc0LjYgMzk1LjEgMjQ2LjQgMzkyLjMgMjIwLjMgMzgyLjJ6Ii8+PC9zdmc+Cg==');opacity:0.5;visibility:hidden;display:inline-block;vertical-align:middle;}/*!sc*/
.casAkG h1:hover>.share-link::before,.casAkG h2:hover>.share-link::before,.casAkG .share-link:hover::before{visibility:visible;}/*!sc*/
.casAkG a{text-decoration:auto;color:#32329f;}/*!sc*/
.casAkG a:visited{color:#32329f;}/*!sc*/
.casAkG a:hover{color:#6868cf;text-decoration:auto;}/*!sc*/
.dujygE{font-family:Roboto,sans-serif;font-weight:400;line-height:1.5em;}/*!sc*/
.dujygE p:last-child{margin-bottom:0;}/*!sc*/
.dujygE p:first-child{margin-top:0;}/*!sc*/
.dujygE p:last-child{margin-bottom:0;}/*!sc*/
.dujygE h1{font-family:Montserrat,sans-serif;font-weight:400;font-size:1.85714em;line-height:1.6em;color:#32329f;margin-top:0;}/*!sc*/
.dujygE h2{font-family:Montserrat,sans-serif;font-weight:400;font-size:1.57143em;line-height:1.6em;color:#333333;}/*!sc*/
.dujygE code{color:#e53935;background-color:rgba(38, 50, 56, 0.05);font-family:Courier,monospace;border-radius:2px;border:1px solid rgba(38, 50, 56, 0.1);padding:0 5px;font-size:13px;font-weight:400;word-break:break-word;}/*!sc*/
.dujygE pre{font-family:Courier,monospace;white-space:pre;background-color:#11171a;color:white;padding:20px;overflow-x:auto;line-height:normal;border-radius:0;border:1px solid rgba(38, 50, 56, 0.1);}/*!sc*/
.dujygE pre code{background-color:transparent;color:white;padding:0;}/*!sc*/
.dujygE pre code:before,.dujygE pre code:after{content:none;}/*!sc*/
.dujygE blockquote{margin:0;margin-bottom:1em;padding:0 15px;color:#777;border-left:4px solid #ddd;}/*!sc*/
.dujygE img{max-width:100%;box-sizing:content-box;}/*!sc*/
.dujygE ul,.dujygE ol{padding-left:2em;margin:0;margin-bottom:1em;}/*!sc*/
.dujygE ul ul,.dujygE ol ul,.dujygE ul ol,.dujygE ol ol{margin-bottom:0;margin-top:0;}/*!sc*/
.dujygE table{display:block;width:100%;overflow:auto;word-break:normal;word-break:keep-all;border-collapse:collapse;border-spacing:0;margin-top:1.5em;margin-bottom:1.5em;}/*!sc*/
.dujygE table tr{background-color:#fff;border-top:1px solid #ccc;}/*!sc*/
.dujygE table tr:nth-child(2n){background-color:#fafafa;}/*!sc*/
.dujygE table th,.dujygE table td{padding:6px 13px;border:1px solid #ddd;}/*!sc*/
.dujygE table th{text-align:left;font-weight:bold;}/*!sc*/
.dujygE .share-link{cursor:pointer;margin-left:-20px;padding:0;line-height:1;width:20px;display:inline-block;outline:0;}/*!sc*/
.dujygE .share-link:before{content:'';width:15px;height:15px;background-size:contain;background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeD0iMCIgeT0iMCIgd2lkdGg9IjUxMiIgaGVpZ2h0PSI1MTIiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cGF0aCBmaWxsPSIjMDEwMTAxIiBkPSJNNDU5LjcgMjMzLjRsLTkwLjUgOTAuNWMtNTAgNTAtMTMxIDUwLTE4MSAwIC03LjktNy44LTE0LTE2LjctMTkuNC0yNS44bDQyLjEtNDIuMWMyLTIgNC41LTMuMiA2LjgtNC41IDIuOSA5LjkgOCAxOS4zIDE1LjggMjcuMiAyNSAyNSA2NS42IDI0LjkgOTAuNSAwbDkwLjUtOTAuNWMyNS0yNSAyNS02NS42IDAtOTAuNSAtMjQuOS0yNS02NS41LTI1LTkwLjUgMGwtMzIuMiAzMi4yYy0yNi4xLTEwLjItNTQuMi0xMi45LTgxLjYtOC45bDY4LjYtNjguNmM1MC01MCAxMzEtNTAgMTgxIDBDNTA5LjYgMTAyLjMgNTA5LjYgMTgzLjQgNDU5LjcgMjMzLjR6TTIyMC4zIDM4Mi4ybC0zMi4yIDMyLjJjLTI1IDI0LjktNjUuNiAyNC45LTkwLjUgMCAtMjUtMjUtMjUtNjUuNiAwLTkwLjVsOTAuNS05MC41YzI1LTI1IDY1LjUtMjUgOTAuNSAwIDcuOCA3LjggMTIuOSAxNy4yIDE1LjggMjcuMSAyLjQtMS40IDQuOC0yLjUgNi44LTQuNWw0Mi4xLTQyYy01LjQtOS4yLTExLjYtMTgtMTkuNC0yNS44IC01MC01MC0xMzEtNTAtMTgxIDBsLTkwLjUgOTAuNWMtNTAgNTAtNTAgMTMxIDAgMTgxIDUwIDUwIDEzMSA1MCAxODEgMGw2OC42LTY4LjZDMjc0LjYgMzk1LjEgMjQ2LjQgMzkyLjMgMjIwLjMgMzgyLjJ6Ii8+PC9zdmc+Cg==');opacity:0.5;visibility:hidden;display:inline-block;vertical-align:middle;}/*!sc*/
.dujygE h1:hover>.share-link::before,.dujygE h2:hover>.share-link::before,.dujygE .share-link:hover::before{visibility:visible;}/*!sc*/
.dujygE a{text-decoration:auto;color:#32329f;}/*!sc*/
.dujygE a:visited{color:#32329f;}/*!sc*/
.dujygE a:hover{color:#6868cf;text-decoration:auto;}/*!sc*/
data-styled.g42[id="sc-cBNeRQ"]{content:"casAkG,dujygE,"}/*!sc*/
.bzkUsW{display:inline;}/*!sc*/
data-styled.g43[id="sc-citwID"]{content:"bzkUsW,"}/*!sc*/
.iVrxDL{position:relative;}/*!sc*/
data-styled.g44[id="sc-jcVcfa"]{content:"iVrxDL,"}/*!sc*/
.gLzJQv:hover>.sc-giInvV{opacity:1;}/*!sc*/
data-styled.g49[id="sc-cTkyaV"]{content:"gLzJQv,"}/*!sc*/
.jXmkAn{font-family:Courier,monospace;font-size:13px;white-space:pre;contain:content;overflow-x:auto;}/*!sc*/
.jXmkAn .redoc-json code>.collapser{display:none;pointer-events:none;}/*!sc*/
.jXmkAn .callback-function{color:gray;}/*!sc*/
.jXmkAn .collapser:after{content:'-';cursor:pointer;}/*!sc*/
.jXmkAn .collapsed>.collapser:after{content:'+';cursor:pointer;}/*!sc*/
.jXmkAn .ellipsis:after{content:' … ';}/*!sc*/
.jXmkAn .collapsible{margin-left:2em;}/*!sc*/
.jXmkAn .hoverable{padding-top:1px;padding-bottom:1px;padding-left:2px;padding-right:2px;border-radius:2px;}/*!sc*/
.jXmkAn .hovered{background-color:rgba(235, 238, 249, 1);}/*!sc*/
.jXmkAn .collapser{background-color:transparent;border:0;color:#fff;font-family:Courier,monospace;font-size:13px;padding-right:6px;padding-left:6px;padding-top:0;padding-bottom:0;display:flex;align-items:center;justify-content:center;width:15px;height:15px;position:absolute;top:4px;left:-1.5em;cursor:default;user-select:none;-webkit-user-select:none;padding:2px;}/*!sc*/
.jXmkAn .collapser:focus{outline-color:#fff;outline-style:dotted;outline-width:1px;}/*!sc*/
.jXmkAn ul{list-style-type:none;padding:0px;margin:0px 0px 0px 26px;}/*!sc*/
.jXmkAn li{position:relative;display:block;}/*!sc*/
.jXmkAn .hoverable{display:inline-block;}/*!sc*/
.jXmkAn .selected{outline-style:solid;outline-width:1px;outline-style:dotted;}/*!sc*/
.jXmkAn .collapsed>.collapsible{display:none;}/*!sc*/
.jXmkAn .ellipsis{display:none;}/*!sc*/
.jXmkAn .collapsed>.ellipsis{display:inherit;}/*!sc*/
data-styled.g50[id="sc-jNMdxs"]{content:"jXmkAn,"}/*!sc*/
.bAzVww{padding:0.9em;background-color:rgba(38,50,56,0.4);margin:0 0 10px 0;display:block;font-family:Montserrat,sans-serif;font-size:0.929em;line-height:1.5em;}/*!sc*/
data-styled.g51[id="sc-dOSSlk"]{content:"bAzVww,"}/*!sc*/
.etjuEr{font-family:Montserrat,sans-serif;font-size:12px;position:absolute;z-index:1;top:-11px;left:12px;font-weight:600;color:rgba(255,255,255,0.7);}/*!sc*/
data-styled.g52[id="sc-bBrOHt"]{content:"etjuEr,"}/*!sc*/
.eDzWuJ{position:relative;}/*!sc*/
data-styled.g53[id="sc-cOaiZO"]{content:"eDzWuJ,"}/*!sc*/
.kTaCsY{margin-top:15px;}/*!sc*/
data-styled.g56[id="sc-hTZhMB"]{content:"kTaCsY,"}/*!sc*/
.ihUpGF{vertical-align:middle;font-size:13px;line-height:20px;}/*!sc*/
data-styled.g58[id="sc-gTgyBf"]{content:"ihUpGF,"}/*!sc*/
.cREGdc{color:rgba(102,102,102,0.9);}/*!sc*/
data-styled.g59[id="sc-laRQQM"]{content:"cREGdc,"}/*!sc*/
.iPuJRj{color:#666;}/*!sc*/
data-styled.g60[id="sc-iNqNmV"]{content:"iPuJRj,"}/*!sc*/
.cEfEOv{border-radius:2px;word-break:break-word;background-color:rgba(51,51,51,0.05);color:rgba(51,51,51,0.9);padding:0 5px;border:1px solid rgba(51,51,51,0.1);font-family:Courier,monospace;}/*!sc*/
+{margin-left:0;}/*!sc*/
data-styled.g66[id="sc-lcuiaG"]{content:"cEfEOv,"}/*!sc*/
.hWeMwQ{margin-top:0;margin-bottom:0.5em;}/*!sc*/
data-styled.g91[id="sc-eGCbyA"]{content:"hWeMwQ,"}/*!sc*/
.gUXnfH{border:1px solid #32329f;color:#32329f;font-weight:normal;margin-left:0.5em;padding:4px 8px 4px;display:inline-block;text-decoration:none;cursor:pointer;}/*!sc*/
data-styled.g92[id="sc-ctaXUJ"]{content:"gUXnfH,"}/*!sc*/
.kqapCx{max-height:260px;max-width:260px;padding:2px;width:100%;display:block;}/*!sc*/
data-styled.g96[id="sc-euMqrB"]{content:"kqapCx,"}/*!sc*/
.cDbXOe{text-align:center;}/*!sc*/
data-styled.g97[id="sc-fHuKJW"]{content:"cDbXOe,"}/*!sc*/
.bwwtyo{width:9ex;display:inline-block;height:13px;line-height:13px;background-color:#333;border-radius:3px;background-repeat:no-repeat;background-position:6px 4px;font-size:7px;font-family:Verdana,sans-serif;color:white;text-transform:uppercase;text-align:center;font-weight:bold;vertical-align:middle;margin-right:6px;margin-top:2px;}/*!sc*/
.bwwtyo.get{background-color:#2F8132;}/*!sc*/
.bwwtyo.post{background-color:#186FAF;}/*!sc*/
.bwwtyo.put{background-color:#95507c;}/*!sc*/
.bwwtyo.options{background-color:#947014;}/*!sc*/
.bwwtyo.patch{background-color:#bf581d;}/*!sc*/
.bwwtyo.delete{background-color:#cc3333;}/*!sc*/
.bwwtyo.basic{background-color:#707070;}/*!sc*/
.bwwtyo.link{background-color:#07818F;}/*!sc*/
.bwwtyo.head{background-color:#A23DAD;}/*!sc*/
.bwwtyo.hook{background-color:#32329f;}/*!sc*/
.bwwtyo.schema{background-color:#707070;}/*!sc*/
data-styled.g99[id="sc-dkIYMQ"]{content:"bwwtyo,"}/*!sc*/
.YKcaq{margin:0;padding:0;}/*!sc*/
.YKcaq:first-child{padding-bottom:32px;}/*!sc*/
.sc-XhViZ .sc-XhViZ{font-size:0.929em;}/*!sc*/
data-styled.g100[id="sc-XhViZ"]{content:"YKcaq,"}/*!sc*/
.fhNqYr{list-style:none inside none;overflow:hidden;text-overflow:ellipsis;padding:0;}/*!sc*/
data-styled.g101[id="sc-ikPBrU"]{content:"fhNqYr,"}/*!sc*/
.CYQVt{cursor:pointer;color:#333333;margin:0;padding:12.5px 20px;display:flex;justify-content:space-between;font-family:Montserrat,sans-serif;background-color:#fafafa;}/*!sc*/
.CYQVt:hover{color:#32329f;background-color:#ededed;}/*!sc*/
.CYQVt .sc-dQpIV{height:1.5em;width:1.5em;}/*!sc*/
.CYQVt .sc-dQpIV polygon{fill:#333333;}/*!sc*/
data-styled.g102[id="sc-tYqQR"]{content:"CYQVt,"}/*!sc*/
.bkVowu{display:inline-block;vertical-align:middle;width:calc(100% - 38px);overflow:hidden;text-overflow:ellipsis;}/*!sc*/
data-styled.g103[id="sc-biBryG"]{content:"bkVowu,"}/*!sc*/
.jrtoRW{font-size:0.8em;margin-top:10px;text-align:center;position:fixed;width:260px;bottom:0;background:#fafafa;}/*!sc*/
.jrtoRW a,.jrtoRW a:visited,.jrtoRW a:hover{color:#333333!important;padding:5px 0;border-top:1px solid #e1e1e1;text-decoration:none;display:flex;align-items:center;justify-content:center;}/*!sc*/
.jrtoRW img{width:15px;margin-right:5px;}/*!sc*/
@media screen and (max-width: 50rem){.jrtoRW{width:100%;}}/*!sc*/
data-styled.g104[id="sc-eHfQwz"]{content:"jrtoRW,"}/*!sc*/
.bhuodb{cursor:pointer;position:relative;margin-bottom:5px;}/*!sc*/
data-styled.g110[id="sc-bQdSiB"]{content:"bhuodb,"}/*!sc*/
.jzevEV{font-family:Courier,monospace;margin-left:10px;flex:1;overflow-x:hidden;text-overflow:ellipsis;}/*!sc*/
data-styled.g111[id="sc-fXoxOd"]{content:"jzevEV,"}/*!sc*/
.jlriCd{outline:0;color:inherit;width:100%;text-align:left;cursor:pointer;padding:10px 30px 10px 20px;border-radius:4px 4px 0 0;background-color:#11171a;display:flex;white-space:nowrap;align-items:center;border:1px solid transparent;border-bottom:0;transition:border-color 0.25s ease;}/*!sc*/
.jlriCd ..sc-fXoxOd{color:#ffffff;}/*!sc*/
.jlriCd:focus{box-shadow:inset 0 2px 2px rgba(0, 0, 0, 0.45),0 2px 0 rgba(128, 128, 128, 0.25);}/*!sc*/
data-styled.g112[id="sc-FyfbU"]{content:"jlriCd,"}/*!sc*/
.gDPfwK{font-size:0.929em;line-height:20px;background-color:#2F8132;color:#ffffff;padding:3px 10px;text-transform:uppercase;font-family:Montserrat,sans-serif;margin:0;}/*!sc*/
data-styled.g113[id="sc-jXkspL"]{content:"gDPfwK,"}/*!sc*/
.ciRGmD{position:absolute;width:100%;z-index:100;background:#fafafa;color:#263238;box-sizing:border-box;box-shadow:0 0 6px rgba(0, 0, 0, 0.33);overflow:hidden;border-bottom-left-radius:4px;border-bottom-right-radius:4px;transition:all 0.25s ease;visibility:hidden;transform:translateY(-50%) scaleY(0);}/*!sc*/
data-styled.g114[id="sc-eFtZDC"]{content:"ciRGmD,"}/*!sc*/
.buTZbL{padding:10px;}/*!sc*/
data-styled.g115[id="sc-fmlKft"]{content:"buTZbL,"}/*!sc*/
.uePtT{padding:5px;border:1px solid #ccc;background:#fff;word-break:break-all;color:#32329f;}/*!sc*/
.uePtT >span{color:#333333;}/*!sc*/
data-styled.g116[id="sc-ljRaSg"]{content:"uePtT,"}/*!sc*/
.eEqsZl{display:block;border:0;width:100%;text-align:left;padding:10px;border-radius:2px;margin-bottom:4px;line-height:1.5em;cursor:pointer;color:#1d8127;background-color:rgba(29,129,39,0.07);cursor:default;}/*!sc*/
.eEqsZl:focus{outline:auto #1d8127;}/*!sc*/
.eEqsZl::before{content:"—";font-weight:bold;width:1.5em;text-align:center;display:inline-block;vertical-align:top;}/*!sc*/
.eEqsZl:focus{outline:0;}/*!sc*/
.jifJmL{display:block;border:0;width:100%;text-align:left;padding:10px;border-radius:2px;margin-bottom:4px;line-height:1.5em;cursor:pointer;color:#d41f1c;background-color:rgba(212,31,28,0.07);cursor:default;}/*!sc*/
.jifJmL:focus{outline:auto #d41f1c;}/*!sc*/
.jifJmL::before{content:"—";font-weight:bold;width:1.5em;text-align:center;display:inline-block;vertical-align:top;}/*!sc*/
.jifJmL:focus{outline:0;}/*!sc*/
data-styled.g119[id="sc-httZfN"]{content:"eEqsZl,jifJmL,"}/*!sc*/
.goojcW{vertical-align:top;}/*!sc*/
data-styled.g122[id="sc-gVgoeb"]{content:"goojcW,"}/*!sc*/
.fCsSHf{font-size:1.3em;padding:0.2em 0;margin:3em 0 1.1em;color:#333333;font-weight:normal;}/*!sc*/
data-styled.g123[id="sc-fWPdKs"]{content:"fCsSHf,"}/*!sc*/
.iEVneI{user-select:none;width:20px;height:20px;align-self:center;display:flex;flex-direction:column;color:#32329f;}/*!sc*/
data-styled.g129[id="sc-iGctyi"]{content:"iEVneI,"}/*!sc*/
.gXSQkB{width:260px;background-color:#fafafa;overflow:hidden;display:flex;flex-direction:column;backface-visibility:hidden;height:100vh;position:sticky;position:-webkit-sticky;top:0;}/*!sc*/
@media screen and (max-width: 50rem){.gXSQkB{position:fixed;z-index:20;width:100%;background:#fafafa;display:none;}}/*!sc*/
@media print{.gXSQkB{display:none;}}/*!sc*/
data-styled.g130[id="sc-irlPvL"]{content:"gXSQkB,"}/*!sc*/
.bEOmaQ{outline:none;user-select:none;background-color:#f2f2f2;color:#32329f;display:none;cursor:pointer;position:fixed;right:20px;z-index:100;border-radius:50%;box-shadow:0 0 20px rgba(0, 0, 0, 0.3);bottom:44px;width:60px;height:60px;padding:0 20px;}/*!sc*/
@media screen and (max-width: 50rem){.bEOmaQ{display:flex;}}/*!sc*/
.bEOmaQ svg{color:#0065FB;}/*!sc*/
@media print{.bEOmaQ{display:none;}}/*!sc*/
data-styled.g131[id="sc-eWvOCH"]{content:"bEOmaQ,"}/*!sc*/
.bwTiCm{font-family:Roboto,sans-serif;font-size:14px;font-weight:400;line-height:1.5em;color:#333333;display:flex;position:relative;text-align:left;-webkit-font-smoothing:antialiased;font-smoothing:antialiased;text-rendering:optimizeSpeed!important;tap-highlight-color:rgba(0, 0, 0, 0);text-size-adjust:100%;}/*!sc*/
.bwTiCm *{box-sizing:border-box;-webkit-tap-highlight-color:rgba(255, 255, 255, 0);}/*!sc*/
data-styled.g132[id="sc-kUbfpu"]{content:"bwTiCm,"}/*!sc*/
.dPIjnf{z-index:1;position:relative;overflow:hidden;width:calc(100% - 260px);contain:layout;}/*!sc*/
@media print,screen and (max-width: 50rem){.dPIjnf{width:100%;}}/*!sc*/
data-styled.g133[id="sc-dwcvcB"]{content:"dPIjnf,"}/*!sc*/
.gfiMgB{background:#263238;position:absolute;top:0;bottom:0;right:0;width:calc((100% - 260px) * 0.4);}/*!sc*/
@media print,screen and (max-width: 75rem){.gfiMgB{display:none;}}/*!sc*/
data-styled.g134[id="sc-jtHLPo"]{content:"gfiMgB,"}/*!sc*/
.hwhlAl{padding:5px 0;}/*!sc*/
data-styled.g135[id="sc-eltaTX"]{content:"hwhlAl,"}/*!sc*/
.eWIXbA{width:calc(100% - 40px);box-sizing:border-box;margin:0 20px;padding:5px 10px 5px 20px;border:0;border-bottom:1px solid #e1e1e1;font-family:Roboto,sans-serif;font-weight:bold;font-size:13px;color:#333333;background-color:transparent;outline:none;}/*!sc*/
data-styled.g136[id="sc-kiYrGK"]{content:"eWIXbA,"}/*!sc*/
.lcoFQc{position:absolute;left:20px;height:1.8em;width:0.9em;}/*!sc*/
.lcoFQc path{fill:#333333;}/*!sc*/
data-styled.g137[id="sc-cKZHtR"]{content:"lcoFQc,"}/*!sc*/
</style>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700|Roboto:300,400,700" rel="stylesheet">
</head>

<body>
  
      <div id="redoc"><div class="sc-kUbfpu bwTiCm redoc-wrap"><div class="sc-irlPvL gXSQkB menu-content" style="top:0px;height:calc(100vh - 0px)"><div class="sc-fHuKJW cDbXOe"><img src="https://eac.greg.cy/images/calculator.png" alt="EAC Calculator" class="sc-euMqrB kqapCx"/></div><div role="search" class="sc-eltaTX hwhlAl"><svg class="sc-cKZHtR lcoFQc search-icon" version="1.1" viewBox="0 0 1000 1000" x="0px" xmlns="http://www.w3.org/2000/svg" y="0px"><path d="M968.2,849.4L667.3,549c83.9-136.5,66.7-317.4-51.7-435.6C477.1-25,252.5-25,113.9,113.4c-138.5,138.3-138.5,362.6,0,501C219.2,730.1,413.2,743,547.6,666.5l301.9,301.4c43.6,43.6,76.9,14.9,104.2-12.4C981,928.3,1011.8,893,968.2,849.4z M524.5,522c-88.9,88.7-233,88.7-321.8,0c-88.9-88.7-88.9-232.6,0-321.3c88.9-88.7,233-88.7,321.8,0C613.4,289.4,613.4,433.3,524.5,522z"></path></svg><input placeholder="Search..." aria-label="Search" type="text" class="sc-kiYrGK eWIXbA search-input" value=""/></div><div class="sc-kLgoAE eJckYb scrollbar-container undefined"><ul role="menu" class="sc-XhViZ YKcaq"><li tabindex="0" depth="2" data-item-id="operation/getCurrentRate" role="menuitem" class="sc-ikPBrU fhNqYr"><label class="sc-tYqQR CYQVt -depth2"><span type="get" class="sc-dkIYMQ bwwtyo operation-type get">get</span><span tabindex="0" width="calc(100% - 38px)" class="sc-biBryG bkVowu">getCurrentRate</span></label></li></ul><div class="sc-eHfQwz jrtoRW"><a target="_blank" rel="noopener noreferrer" href="https://redocly.com/redoc/">API docs by Redocly</a></div></div></div><div class="sc-eWvOCH bEOmaQ"><div class="sc-iGctyi iEVneI"><svg class="" style="transform:translate(2px, -4px) rotate(180deg);transition:transform 0.2s ease" viewBox="0 0 926.23699 573.74994" version="1.1" x="0px" y="0px" width="15" height="15"><g transform="translate(904.92214,-879.1482)"><path d="
          m -673.67664,1221.6502 -231.2455,-231.24803 55.6165,
          -55.627 c 30.5891,-30.59485 56.1806,-55.627 56.8701,-55.627 0.6894,
          0 79.8637,78.60862 175.9427,174.68583 l 174.6892,174.6858 174.6892,
          -174.6858 c 96.079,-96.07721 175.253196,-174.68583 175.942696,
          -174.68583 0.6895,0 26.281,25.03215 56.8701,
          55.627 l 55.6165,55.627 -231.245496,231.24803 c -127.185,127.1864
          -231.5279,231.248 -231.873,231.248 -0.3451,0 -104.688,
          -104.0616 -231.873,-231.248 z
        " fill="currentColor"></path></g></svg><svg class="" style="transform:translate(2px, 4px);transition:transform 0.2s ease" viewBox="0 0 926.23699 573.74994" version="1.1" x="0px" y="0px" width="15" height="15"><g transform="translate(904.92214,-879.1482)"><path d="
          m -673.67664,1221.6502 -231.2455,-231.24803 55.6165,
          -55.627 c 30.5891,-30.59485 56.1806,-55.627 56.8701,-55.627 0.6894,
          0 79.8637,78.60862 175.9427,174.68583 l 174.6892,174.6858 174.6892,
          -174.6858 c 96.079,-96.07721 175.253196,-174.68583 175.942696,
          -174.68583 0.6895,0 26.281,25.03215 56.8701,
          55.627 l 55.6165,55.627 -231.245496,231.24803 c -127.185,127.1864
          -231.5279,231.248 -231.873,231.248 -0.3451,0 -104.688,
          -104.0616 -231.873,-231.248 z
        " fill="currentColor"></path></g></svg></div></div><div class="sc-dwcvcB dPIjnf api-content"><div class="sc-eCstZk kxmVZO"><div class="sc-iBPTVF keMybc"><div class="sc-hKgKIp gvoNGN api-info"><h1 class="sc-fubDmA sc-eGCbyA djltfY hWeMwQ">Cyprus Electricity cost API<!-- --> <span>(<!-- -->1.0.0<!-- -->)</span></h1><p>Download OpenAPI specification<!-- -->:<a download="openapi.json" target="_blank" class="sc-ctaXUJ gUXnfH">Download</a></p><div class="sc-iJuWdM sc-cBNeRQ gpkGbA casAkG"></div><div data-role="redoc-summary" html="" class="sc-iJuWdM sc-cBNeRQ gpkGbA casAkG"></div><div data-role="redoc-description" html="&lt;p&gt;An API to get the current cost of electricity in Cyprus.&lt;/p&gt;
" class="sc-iJuWdM sc-cBNeRQ gpkGbA casAkG"><p>An API to get the current cost of electricity in Cyprus.</p>
</div></div></div></div><div id="operation/getCurrentRate" data-section-id="operation/getCurrentRate" class="sc-eCstZk bCpIRB"><div data-section-id="operation/getCurrentRate" id="operation/getCurrentRate" class="sc-iBPTVF keMybc"><div class="sc-hKgKIp gvoNGN"><h2 class="sc-pGaPU biKwui"><a class="sc-crrtmM jGBpue" href="#operation/getCurrentRate" aria-label="operation/getCurrentRate"></a>getCurrentRate<!-- --> </h2><div><h5 class="sc-iqHXzD bRzaSI">query<!-- --> Parameters</h5><table class="sc-hHftZz buUaAP"><tbody><tr class=""><td kind="field" title="tariffCode" class="sc-hBEZvw sc-fFubCH gPUvwc gXIfsF"><span class="sc-idOjMB jwsifT"></span><span class="property-name">tariffCode</span></td><td class="sc-bkzXAi kMAhqG"><div><div><span class="sc-gTgyBf sc-laRQQM ihUpGF cREGdc"></span><span class="sc-gTgyBf sc-iNqNmV ihUpGF iPuJRj">string</span></div><div><span class="sc-gTgyBf ihUpGF"> <!-- -->Default:<!-- --> </span> <span class="sc-gTgyBf sc-lcuiaG ihUpGF cEfEOv">&quot;01&quot;</span></div><div><span class="sc-gTgyBf ihUpGF"> <!-- -->Enum<!-- -->:</span> <span class="sc-gTgyBf sc-lcuiaG ihUpGF cEfEOv">&quot;01&quot;</span> <span class="sc-gTgyBf sc-lcuiaG ihUpGF cEfEOv">&quot;02&quot;</span> <span class="sc-gTgyBf sc-lcuiaG ihUpGF cEfEOv">&quot;08&quot;</span> </div> <div><div html="&lt;p&gt;The tariff code for which you want to get the current rate. Allowed values: &amp;quot;01&amp;quot;, &amp;quot;02&amp;quot;, &amp;quot;08&amp;quot;.&lt;/p&gt;
" class="sc-iJuWdM sc-cBNeRQ gpkGbA dujygE"><p>The tariff code for which you want to get the current rate. Allowed values: &quot;01&quot;, &quot;02&quot;, &quot;08&quot;.</p>
</div></div></div></td></tr><tr class="last "><td kind="field" title="creditUnits" class="sc-hBEZvw sc-fFubCH gPUvwc gXIfsF"><span class="sc-idOjMB jwsifT"></span><span class="property-name">creditUnits</span></td><td class="sc-bkzXAi kMAhqG"><div><div><span class="sc-gTgyBf sc-laRQQM ihUpGF cREGdc"></span><span class="sc-gTgyBf sc-iNqNmV ihUpGF iPuJRj">boolean</span></div><div><span class="sc-gTgyBf ihUpGF"> <!-- -->Default:<!-- --> </span> <span class="sc-gTgyBf sc-lcuiaG ihUpGF cEfEOv">false</span></div> <div><div html="&lt;p&gt;A boolean indicating if you have credit units from net metering.&lt;/p&gt;
" class="sc-iJuWdM sc-cBNeRQ gpkGbA dujygE"><p>A boolean indicating if you have credit units from net metering.</p>
</div></div></div></td></tr></tbody></table></div><div><h3 class="sc-fWPdKs fCsSHf">Responses</h3><div><button class="sc-httZfN eEqsZl" disabled=""><strong class="sc-gVgoeb goojcW">200<!-- --> </strong><div html="&lt;p&gt;Successful response&lt;/p&gt;
" class="sc-iJuWdM sc-cBNeRQ gpkGbA casAkG sc-citwID bzkUsW"><p>Successful response</p>
</div></button></div><div><button class="sc-httZfN jifJmL" disabled=""><strong class="sc-gVgoeb goojcW">400<!-- --> </strong><div html="&lt;p&gt;Bad request&lt;/p&gt;
" class="sc-iJuWdM sc-cBNeRQ gpkGbA casAkG sc-citwID bzkUsW"><p>Bad request</p>
</div></button></div></div></div><div class="sc-jSguLX sc-gKsecS QymcT bZqtR"><div class="sc-bQdSiB bhuodb"><button class="sc-FyfbU jlriCd"><span type="get" class="sc-jXkspL gDPfwK http-verb get">get</span><span class="sc-fXoxOd jzevEV">/api/getCurrentRate</span><svg class="sc-dQpIV hHbBnT" style="margin-right:-25px" version="1.1" viewBox="0 0 24 24" x="0" xmlns="http://www.w3.org/2000/svg" y="0" aria-hidden="true"><polygon points="17.3 8.3 12 13.6 6.7 8.3 5.3 9.7 12 16.4 18.7 9.7 "></polygon></svg></button><div aria-hidden="true" class="sc-eFtZDC ciRGmD"><div class="sc-fmlKft buTZbL"><div html="" class="sc-iJuWdM sc-cBNeRQ gpkGbA dujygE"></div><div tabindex="0" role="button"><div class="sc-ljRaSg uePtT"><span>https://eac.greg.cy/api</span>/api/getCurrentRate</div></div></div></div></div><div><h3 class="sc-kEjbdu jmifsN"> <!-- -->Response samples<!-- --> </h3><div class="sc-cxFKTC jVRsAZ" data-rttabs="true"><ul class="react-tabs__tab-list" role="tablist"><li class="tab-success react-tabs__tab--selected" role="tab" id="react-tabs-0" aria-selected="true" aria-disabled="false" aria-controls="react-tabs-1" tabindex="0" data-rttab="true">200</li><li class="tab-error" role="tab" id="react-tabs-2" aria-selected="false" aria-disabled="false" aria-controls="react-tabs-3" data-rttab="true">400</li></ul><div class="react-tabs__tab-panel react-tabs__tab-panel--selected" role="tabpanel" id="react-tabs-1" aria-labelledby="react-tabs-0"><div><div class="sc-cOaiZO eDzWuJ"><span class="sc-bBrOHt etjuEr">Content type</span><div class="sc-dOSSlk bAzVww">application/json</div></div><div class="sc-hTZhMB kTaCsY"><div class="sc-cTkyaV gLzJQv"><div class="sc-giInvV bIDavi"><button><div class="sc-jcVcfa iVrxDL">Copy</div></button><button> Expand all </button><button> Collapse all </button></div><div class="sc-iJuWdM gpkGbA sc-jNMdxs jXmkAn"><div class="redoc-json"><code><button class="collapser" aria-label="collapse"></button><span class="token punctuation">{</span><span class="ellipsis"></span><ul class="obj collapsible"><li><div class="hoverable "><span class="property token string">"measurement"</span>: <span class="token string">&quot;€/kWh&quot;</span><span class="token punctuation">,</span></div></li><li><div class="hoverable "><span class="property token string">"total"</span>: <span class="token number">0.333658</span><span class="token punctuation">,</span></div></li><li><div class="hoverable "><span class="property token string">"breakdown"</span>: <button class="collapser" aria-label="collapse"></button><span class="token punctuation">{</span><span class="ellipsis"></span><ul class="obj collapsible"><li><div class="hoverable collapsed"><span class="property token string">"electricityGeneration"</span>: <span class="token number">0.1035</span><span class="token punctuation">,</span></div></li><li><div class="hoverable collapsed"><span class="property token string">"networkUsage"</span>: <span class="token number">0.0302</span><span class="token punctuation">,</span></div></li><li><div class="hoverable collapsed"><span class="property token string">"ancillaryServices"</span>: <span class="token number">0.0065</span><span class="token punctuation">,</span></div></li><li><div class="hoverable collapsed"><span class="property token string">"fuelAdjustment"</span>: <span class="token number">0.137878</span><span class="token punctuation">,</span></div></li><li><div class="hoverable collapsed"><span class="property token string">"publicServiceObligation"</span>: <span class="token number">0.00058</span><span class="token punctuation">,</span></div></li><li><div class="hoverable collapsed"><span class="property token string">"resEsFund"</span>: <span class="token number">0.005</span><span class="token punctuation">,</span></div></li><li><div class="hoverable collapsed"><span class="property token string">"vat"</span>: <span class="token number">0.052945</span></div></li></ul><span class="token punctuation">}</span></div></li></ul><span class="token punctuation">}</span></code></div></div></div></div></div></div><div class="react-tabs__tab-panel" role="tabpanel" id="react-tabs-3" aria-labelledby="react-tabs-2"></div></div></div></div></div></div></div><div class="sc-jtHLPo gfiMgB"></div></div></div>
      <script>
      const __redoc_state = {"menu":{"activeItemIdx":-1},"spec":{"data":{"openapi":"3.0.0","info":{"title":"Cyprus Electricity cost API","version":"1.0.0","description":"An API to get the current cost of electricity in Cyprus.","x-logo":{"url":"https://eac.greg.cy/images/calculator.png","altText":"EAC Calculator"}},"servers":[{"url":"https://eac.greg.cy/api"}],"paths":{"/api/getCurrentRate":{"get":{"summary":"getCurrentRate","operationId":"getCurrentRate","parameters":[{"name":"tariffCode","in":"query","description":"The tariff code for which you want to get the current rate. Allowed values: \"01\", \"02\", \"08\".","required":false,"schema":{"type":"string","default":"01","enum":["01","02","08"]}},{"name":"creditUnits","in":"query","description":"A boolean indicating if you have credit units from net metering.","required":false,"schema":{"type":"boolean","default":false}}],"responses":{"200":{"description":"Successful response","content":{"application/json":{"example":{"measurement":"€/kWh","total":0.333658,"breakdown":{"electricityGeneration":0.1035,"networkUsage":0.0302,"ancillaryServices":0.0065,"fuelAdjustment":0.137878,"publicServiceObligation":0.00058,"resEsFund":0.005,"vat":0.052945}}}}},"400":{"description":"Bad request","content":{"application/json":{"example":{"error":"The selected tariff code is invalid."}}}}}}}},"components":{}}},"searchIndex":{"store":["operation/getCurrentRate"],"index":{"version":"2.3.9","fields":["title","description"],"fieldVectors":[["title/0",[0,0.288]],["description/0",[1,0.288]]],"invertedIndex":[["api/getcurrentr",{"_index":1,"title":{},"description":{"0":{}}}],["getcurrentr",{"_index":0,"title":{"0":{}},"description":{}}]],"pipeline":[]}},"options":{}};

      var container = document.getElementById('redoc');
      Redoc.hydrate(__redoc_state, container);

      </script>
</body>

</html>
