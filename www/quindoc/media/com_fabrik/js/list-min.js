var FbList=new Class({Implements:[Options,Events],options:{admin:false,filterMethod:"onchange",ajax:false,ajax_links:false,links:{edit:"",detail:"",add:""},form:"listform_"+this.id,hightLight:"#ccffff",primaryKey:"",headings:[],labels:{},Itemid:0,formid:0,canEdit:true,canView:true,page:"index.php",actionMethod:"floating",formels:[],data:[],rowtemplate:"",floatPos:"left",csvChoose:false,csvOpts:{},popup_width:300,popup_height:300,popup_offset_x:null,popup_offset_y:null,groupByOpts:{},listRef:"",fabrik_show_in_list:[],singleOrdering:false,tmpl:"",groupedBy:"",toggleCols:false},initialize:function(b,a){this.id=b;this.setOptions(a);this.getForm();this.result=true;this.plugins=[];this.list=document.id("list_"+this.options.listRef);if(this.options.j3===false){this.actionManager=new FbListActions(this,{method:this.options.actionMethod,floatPos:this.options.floatPos})}if(this.options.toggleCols){this.toggleCols=new FbListToggle(this.form)}this.groupToggle=new FbGroupedToggler(this.form,this.options.groupByOpts);new FbListKeys(this);if(this.list){if(this.list.get("tag")==="table"){this.tbody=this.list.getElement("tbody")}if(typeOf(this.tbody)==="null"){this.tbody=this.list}if(window.ie){this.options.rowtemplate=this.list.getElement(".fabrik_row")}}this.watchAll(false);Fabrik.addEvent("fabrik.form.submitted",function(){this.updateRows()}.bind(this));if(!!(window.history&&history.pushState)&&history.state&&this.options.ajax){this._updateRows(history.state)}},setRowTemplate:function(){if(typeOf(this.options.rowtemplate)==="string"){var a=this.list.getElement(".fabrik_row");if(window.ie&&typeOf(a)!=="null"){this.options.rowtemplate=a}}},rowClicks:function(){this.list.addEvent("click:relay(.fabrik_row)",function(g,b){var h=Array.from(b.id.split("_")),f={};f.rowid=h.getLast();var a={errors:{},data:f,rowid:h.getLast(),listid:this.id};Fabrik.fireEvent("fabrik.list.row.selected",a)}.bind(this))},watchAll:function(a){a=a?a:false;this.watchNav();this.storeCurrentValue();if(!a){this.watchRows();this.watchFilters()}this.watchOrder();this.watchEmpty();if(!a){this.watchGroupByMenu();this.watchButtons()}},watchGroupByMenu:function(){if(this.options.ajax){this.form.addEvent("click:relay(*[data-groupBy])",function(b,a){this.options.groupedBy=a.get("data-groupBy");if(b.rightClick){return}b.preventDefault();this.updateRows()}.bind(this))}},watchButtons:function(){this.exportWindowOpts={id:"exportcsv",title:"Export CSV",loadMethod:"html",minimizable:false,width:360,height:120,content:"",bootstrap:this.options.j3};if(this.options.view==="csv"){this.openCSVWindow()}else{if(this.form.getElements(".csvExportButton")){this.form.getElements(".csvExportButton").each(function(a){if(a.hasClass("custom")===false){a.addEvent("click",function(b){this.openCSVWindow();b.stop()}.bind(this))}}.bind(this))}}},openCSVWindow:function(){var a=this.makeCSVExportForm();this.exportWindowOpts.content=a;this.exportWindowOpts.onContentLoaded=function(){this.fitToContent(false)};this.csvWindow=Fabrik.getWindow(this.exportWindowOpts)},makeCSVExportForm:function(){if(this.options.csvChoose){return this._csvExportForm()}else{return this._csvAutoStart()}},_csvAutoStart:function(){var a=new Element("div",{id:"csvmsg"}).set("html",Joomla.JText._("COM_FABRIK_LOADING")+' <br /><span id="csvcount">0</span> / <span id="csvtotal"></span> '+Joomla.JText._("COM_FABRIK_RECORDS")+".<br/>"+Joomla.JText._("COM_FABRIK_SAVING_TO")+'<span id="csvfile"></span>');this.csvopts=this.options.csvOpts;this.csvfields=this.options.csvFields;this.triggerCSVExport(-1);return a},_csvExportForm:function(){var n="<input type='radio' value='1' name='incfilters' checked='checked' />"+Joomla.JText._("JYES");var h="<input type='radio' value='1' name='incraw' checked='checked' />"+Joomla.JText._("JYES");var f="<input type='radio' value='1' name='inccalcs' checked='checked' />"+Joomla.JText._("JYES");var e="<input type='radio' value='1' name='inctabledata' checked='checked' />"+Joomla.JText._("JYES");var d="<input type='radio' value='1' name='excel' checked='checked' />Excel CSV";var a="index.php?option=com_fabrik&view=list&listid="+this.id+"&format=csv&Itemid="+this.options.Itemid;var b={styles:{width:"200px","float":"left"}};var m=new Element("form",{action:a,method:"post"}).adopt([new Element("div",b).set("text",Joomla.JText._("COM_FABRIK_FILE_TYPE")),new Element("label").set("html",d),new Element("label").adopt([new Element("input",{type:"radio",name:"excel",value:"0"}),new Element("span").set("text","CSV")]),new Element("br"),new Element("br"),new Element("div",b).appendText(Joomla.JText._("COM_FABRIK_INCLUDE_FILTERS")),new Element("label").set("html",n),new Element("label").adopt([new Element("input",{type:"radio",name:"incfilters",value:"0"}),new Element("span").set("text",Joomla.JText._("JNO"))]),new Element("br"),new Element("div",b).appendText(Joomla.JText._("COM_FABRIK_INCLUDE_DATA")),new Element("label").set("html",e),new Element("label").adopt([new Element("input",{type:"radio",name:"inctabledata",value:"0"}),new Element("span").set("text",Joomla.JText._("JNO"))]),new Element("br"),new Element("div",b).appendText(Joomla.JText._("COM_FABRIK_INCLUDE_RAW_DATA")),new Element("label").set("html",h),new Element("label").adopt([new Element("input",{type:"radio",name:"incraw",value:"0"}),new Element("span").set("text",Joomla.JText._("JNO"))]),new Element("br"),new Element("div",b).appendText(Joomla.JText._("COM_FABRIK_INCLUDE_CALCULATIONS")),new Element("label").set("html",f),new Element("label").adopt([new Element("input",{type:"radio",name:"inccalcs",value:"0"}),new Element("span").set("text",Joomla.JText._("JNO"))])]);new Element("h4").set("text",Joomla.JText._("COM_FABRIK_SELECT_COLUMNS_TO_EXPORT")).inject(m);var l="";var k=0;$H(this.options.labels).each(function(p,o){if(o.substr(0,7)!=="fabrik_"&&o!=="____form_heading"){var q=o.split("___")[0];if(q!==l){l=q;new Element("h5").set("text",l).inject(m)}var g="<input type='radio' value='1' name='fields["+o+"]' checked='checked' />"+Joomla.JText._("JYES");p=p.replace(/<\/?[^>]+(>|$)/g,"");var s=new Element("div",b).appendText(p);s.inject(m);new Element("label").set("html",g).inject(m);new Element("label").adopt([new Element("input",{type:"radio",name:"fields["+o+"]",value:"0"}),new Element("span").appendText(Joomla.JText._("JNO"))]).inject(m);new Element("br").inject(m)}k++}.bind(this));if(this.options.formels.length>0){new Element("h5").set("text",Joomla.JText._("COM_FABRIK_FORM_FIELDS")).inject(m);this.options.formels.each(function(o){var g="<input type='radio' value='1' name='fields["+o.name+"]' checked='checked' />"+Joomla.JText._("JYES");var p=new Element("div",b).appendText(o.label);p.inject(m);new Element("label").set("html",g).inject(m);new Element("label").adopt([new Element("input",{type:"radio",name:"fields["+o.name+"]",value:"0"}),new Element("span").set("text",Joomla.JText._("JNO"))]).inject(m);new Element("br").inject(m)}.bind(this))}new Element("div",{styles:{"text-align":"right"}}).adopt(new Element("input",{type:"button",name:"submit",value:Joomla.JText._("COM_FABRIK_EXPORT"),"class":"button exportCSVButton",events:{click:function(o){o.stop();o.target.disabled=true;var g=document.id("csvmsg");if(typeOf(g)==="null"){g=new Element("div",{id:"csvmsg"}).inject(o.target,"before")}g.set("html",Joomla.JText._("COM_FABRIK_LOADING")+' <br /><span id="csvcount">0</span> / <span id="csvtotal"></span> '+Joomla.JText._("COM_FABRIK_RECORDS")+".<br/>"+Joomla.JText._("COM_FABRIK_SAVING_TO")+'<span id="csvfile"></span>');this.triggerCSVExport(0)}.bind(this)}})).inject(m);new Element("input",{type:"hidden",name:"view",value:"table"}).inject(m);new Element("input",{type:"hidden",name:"option",value:"com_fabrik"}).inject(m);new Element("input",{type:"hidden",name:"listid",value:this.id}).inject(m);new Element("input",{type:"hidden",name:"format",value:"csv"}).inject(m);new Element("input",{type:"hidden",name:"c",value:"table"}).inject(m);return m},triggerCSVExport:function(e,b,a){if(e!==0){if(e===-1){e=0;b=this.csvopts;b.fields=this.csvfields}else{b=this.csvopts;a=this.csvfields}}else{if(!b){b={};if(typeOf(document.id("exportcsv"))!=="null"){["incfilters","inctabledata","incraw","inccalcs","excel"].each(function(g){var f=document.id("exportcsv").getElements("input[name="+g+"]");if(f.length>0){b[g]=f.filter(function(h){return h.checked})[0].value}})}}if(!a){a={};if(typeOf(document.id("exportcsv"))!=="null"){document.id("exportcsv").getElements("input[name^=field]").each(function(g){if(g.checked){var f=g.name.replace("fields[","").replace("]","");a[f]=g.get("value")}})}}b.fields=a;this.csvopts=b;this.csvfields=a}b=this.csvExportFilterOpts(b);b.start=e;b.option="com_fabrik";b.view="list";b.format="csv";b.Itemid=this.options.Itemid;b.listid=this.id;b.listref=this.options.listRef;b.setListRefFromRequest=1;this.options.csvOpts.custom_qs.split("&").each(function(f){var g=f.split("=");b[g[0]]=g[1]});var d=new Request.JSON({url:"?"+this.options.csvOpts.custom_qs,method:"post",data:b,onError:function(g,f){fconsole(g,f)},onComplete:function(g){if(g.err){alert(g.err);Fabrik.Windows.exportcsv.close()}else{if(typeOf(document.id("csvcount"))!=="null"){document.id("csvcount").set("text",g.count)}if(typeOf(document.id("csvtotal"))!=="null"){document.id("csvtotal").set("text",g.total)}if(typeOf(document.id("csvfile"))!=="null"){document.id("csvfile").set("text",g.file)}if(g.count<g.total){this.triggerCSVExport(g.count)}else{var f="index.php?option=com_fabrik&view=list&format=csv&listid="+this.id+"&start="+g.count+"&Itemid="+this.options.Itemid;var h='<div class="alert alert-success"><h3>'+Joomla.JText._("COM_FABRIK_CSV_COMPLETE");h+='</h3><p><a class="btn btn-success" href="'+f+'"><i class="icon-download"></i> '+Joomla.JText._("COM_FABRIK_CSV_DOWNLOAD_HERE")+"</a></p></div>";if(typeOf(document.id("csvmsg"))!=="null"){document.id("csvmsg").set("html",h)}this.csvWindow.fitToContent(false);document.getElements("input.exportCSVButton").removeProperty("disabled")}}}.bind(this)});d.send()},csvExportFilterOpts:function(e){var d=0,h,g,a=0,f,b=["value","condition","join","key","search_type","match","full_words_only","eval","grouped_to_previous","hidden","elementid"];this.getFilters().each(function(k){g=k.name.split("[");if(g.length>3){f=g[3].replace("]","").toInt();d=f>d?f:d;if(k.get("type")==="checkbox"||k.get("type")==="radio"){if(k.checked){e[k.name]=k.get("value")}}else{e[k.name]=k.get("value")}}}.bind(this));d++;Object.each(this.options.advancedFilters,function(k,l){if(b.contains(l)){a=0;for(h=0;h<k.length;h++){a=h+d;aName="fabrik___filter[list_"+this.options.listRef+"]["+l+"]["+a+"]";e[aName]=k[h]}}}.bind(this));return e},addPlugins:function(b){b.each(function(a){a.list=this}.bind(this));this.plugins=b},firePlugin:function(b){var a=Array.prototype.slice.call(arguments);a=a.slice(1,a.length);this.plugins.each(function(d){Fabrik.fireEvent(b,[this,a])}.bind(this));return this.result===false?false:true},watchEmpty:function(d){var a=document.id(this.options.form).getElement(".doempty");if(a){a.addEvent("click",function(b){b.stop();if(confirm(Joomla.JText._("COM_FABRIK_CONFIRM_DROP"))){this.submit("list.doempty")}}.bind(this))}},watchOrder:function(){var a=false;var b=document.id(this.options.form).getElements(".fabrikorder, .fabrikorder-asc, .fabrikorder-desc");b.removeEvents("click");b.each(function(d){d.addEvent("click",function(m){var g="ordernone.png",n="",k="",f;d=document.id(m.target);var o=d.getParent(".fabrik_ordercell");if(d.tagName!=="a"){d=o.getElement("a")}switch(d.className){case"fabrikorder-asc":k="fabrikorder-desc";f="icon-arrow-up";n="desc";g="orderdesc.png";break;case"fabrikorder-desc":k="fabrikorder";f="icon-menu-2";n="-";g="ordernone.png";break;case"fabrikorder":k="fabrikorder-asc";f="icon-arrow-down";n="asc";g="orderasc.png";break}o.className.split(" ").each(function(e){if(e.contains("_order")){a=e.replace("_order","").replace(/^\s+/g,"").replace(/\s+$/g,"")}});if(!a){fconsole("woops didnt find the element id, cant order");return}d.className=k;var h=d.getElement("img");var l=d.getElement('*[class^="icon"]');if(this.options.singleOrdering){document.id(this.options.form).getElements(".fabrikorder, .fabrikorder-asc, .fabrikorder-desc").each(function(q){if(Fabrik.bootstrapped){var e=q.getElement('*[class^="icon"]');e.className="icon-menu-2"}else{var p=q.getElement("img");if(p){p.src=p.src.replace("ordernone.png","").replace("orderasc.png","").replace("orderdesc.png","");p.src+="ordernone.png"}}})}if(Fabrik.bootstrapped){l.className=f}else{if(h){h.src=h.src.replace("ordernone.png","").replace("orderasc.png","").replace("orderdesc.png","");h.src+=g}}this.fabrikNavOrder(a,n);m.stop()}.bind(this))}.bind(this))},getFilters:function(){return document.id(this.options.form).getElements(".fabrik_filter")},storeCurrentValue:function(){this.getFilters().each(function(a){if(this.options.filterMethod!=="submitform"){a.store("initialvalue",a.get("value"))}}.bind(this))},watchFilters:function(){var b="";var a=document.id(this.options.form).getElements(".fabrik_filter_submit");this.getFilters().each(function(d){b=d.get("tag")==="select"?"change":"blur";if(this.options.filterMethod!=="submitform"){d.removeEvent(b);d.addEvent(b,function(f){f.stop();if(f.target.retrieve("initialvalue")!==f.target.get("value")){this.doFilter()}}.bind(this))}else{d.addEvent(b,function(f){a.highlight("#ffaa00")}.bind(this))}}.bind(this));if(a){a.removeEvents();a.addEvent("click",function(d){d.stop();this.doFilter()}.bind(this))}this.getFilters().addEvent("keydown",function(d){if(d.code===13){d.stop();this.doFilter()}}.bind(this))},doFilter:function(){var a=Fabrik.fireEvent("list.filter",[this]).eventResults;if(typeOf(a)==="null"){this.submit("list.filter")}if(a.length===0||!a.contains(false)){this.submit("list.filter")}},setActive:function(a){this.list.getElements(".fabrik_row").each(function(b){b.removeClass("activeRow")});a.addClass("activeRow")},getActiveRow:function(a){var b=a.target.getParent(".fabrik_row");if(!b){b=Fabrik.activeRow}return b},watchRows:function(){if(!this.list){return}this.rowClicks()},getForm:function(){if(!this.form){this.form=document.id(this.options.form)}return this.form},uncheckAll:function(){this.form.getElements("input[name^=ids]").each(function(a){a.checked=""})},submit:function(d){this.getForm();if(d==="list.delete"){var f=false;var a=0;this.form.getElements("input[name^=ids]").each(function(k){if(k.checked){a++;f=true}});if(!f){alert(Joomla.JText._("COM_FABRIK_SELECT_ROWS_FOR_DELETION"));Fabrik.loader.stop("listform_"+this.options.listRef);return false}var b=a===1?Joomla.JText._("COM_FABRIK_CONFIRM_DELETE_1"):Joomla.JText._("COM_FABRIK_CONFIRM_DELETE").replace("%s",a);if(!confirm(b)){Fabrik.loader.stop("listform_"+this.options.listRef);this.uncheckAll();return false}}if(d==="list.filter"){Fabrik["filter_listform_"+this.options.listRef].onSubmit();this.form.task.value=d;if(this.form["limitstart"+this.id]){this.form.getElement("#limitstart"+this.id).value=0}}else{if(d!==""){this.form.task.value=d}}if(this.options.ajax){Fabrik.loader.start("listform_"+this.options.listRef);this.form.getElement("input[name=option]").value="com_fabrik";this.form.getElement("input[name=view]").value="list";this.form.getElement("input[name=format]").value="raw";var h=this.form.toQueryString();if(d==="list.filter"&&this.advancedSearch!==false){var g=document.getElement("form.advancedSeach_"+this.options.listRef);if(typeOf(g)!=="null"){h+="&"+g.toQueryString();h+="&replacefilters=1"}}for(var e=0;e<this.options.fabrik_show_in_list.length;e++){h+="&fabrik_show_in_list[]="+this.options.fabrik_show_in_list[e]}h+="&tmpl="+this.options.tmpl;if(!this.request){this.request=new Request({url:this.form.get("action"),data:h,onComplete:function(k){k=JSON.decode(k);this._updateRows(k);Fabrik.loader.stop("listform_"+this.options.listRef);Fabrik["filter_listform_"+this.options.listRef].onUpdateData();Fabrik.fireEvent("fabrik.list.submit.ajax.complete",[this,k]);if(k.msg){alert(k.msg)}}.bind(this)})}else{this.request.options.data=h}this.request.send();if(window.history&&window.history.pushState){history.pushState(h,"fabrik.list.submit")}Fabrik.fireEvent("fabrik.list.submit",[d,this.form.toQueryString().toObject()])}else{this.form.submit()}return false},fabrikNav:function(a){this.options.limitStart=a;this.form.getElement("#limitstart"+this.id).value=a;Fabrik.fireEvent("fabrik.list.navigate",[this,a]);if(!this.result){this.result=true;return false}this.submit("list.view");return false},getRowIds:function(){var a=[];var b=this.options.isGrouped?$H(this.options.data):this.options.data;b.each(function(d){d.each(function(e){a.push(e.data.__pk_val)})});return a},getRow:function(b){var a={};Object.each(this.options.data,function(e){for(var d=0;d<e.length;d++){var f=e[d];if(f&&f.data.__pk_val===b){a=f.data}}});return a},fabrikNavOrder:function(a,b){this.form.orderby.value=a;this.form.orderdir.value=b;Fabrik.fireEvent("fabrik.list.order",[this,a,b]);if(!this.result){this.result=true;return false}this.submit("list.order")},removeRows:function(b){for(i=0;i<b.length;i++){var d=document.id("list_"+this.id+"_row_"+b[i]);var a=new Fx.Morph(d,{duration:1000});a.start({backgroundColor:this.options.hightLight}).chain(function(){this.start({opacity:0})}).chain(function(){d.dispose();this.checkEmpty()}.bind(this))}},editRow:function(){},clearRows:function(){this.list.getElements(".fabrik_row").each(function(a){a.dispose()})},updateRows:function(){var b={option:"com_fabrik",view:"list",task:"list.view",format:"raw",listid:this.id,group_by:this.options.groupedBy,listref:this.options.listRef};var a="";b["limit"+this.id]=this.options.limitLength;new Request.JSON({url:a,data:b,onSuccess:function(d){this._updateRows(d)}.bind(this),onError:function(e,d){fconsole(e,d)},onFailure:function(d){fconsole(d)}}).send()},_updateRows:function(d){var e;if(typeOf(d)!=="object"){return}if(window.history&&window.history.pushState){history.pushState(d,"fabrik.list.rows")}if(d.id===this.id&&d.model==="list"){var f=document.id(this.options.form).getElements(".fabrik___heading").getLast();var n=new Hash(d.headings);n.each(function(q,o){o="."+o;try{if(typeOf(f.getElement(o))!=="null"){f.getElement(o).getElement("span").set("html",q)}}catch(p){fconsole(p)}});this.setRowTemplate();this.clearRows();var a=0;var k=0;trs=[];this.options.data=this.options.isGrouped?$H(d.data):d.data;if(d.calculations){this.updateCals(d.calculations)}if(typeOf(this.form.getElement(".fabrikNav"))!=="null"){this.form.getElement(".fabrikNav").set("html",d.htmlnav)}var g=this.options.isGrouped||this.options.groupedBy!==""?$H(d.data):d.data;var l=0;g.each(function(q,p){var o,u;e=this.options.isGrouped?this.list.getElements(".fabrik_groupdata")[l]:this.tbody;if(this.options.isGrouped&&e){groupHeading=e.getPrevious();groupHeading.getElement(".groupTitle").set("html",q[0].groupHeading)}if(typeOf(e)!=="null"){l++;for(i=0;i<q.length;i++){if(typeOf(this.options.rowtemplate)==="string"){o=(this.options.rowtemplate.trim().slice(0,3)==="<tr")?"table":"div";u=new Element(o);u.set("html",this.options.rowtemplate)}else{o=this.options.rowtemplate.get("tag")==="tr"?"table":"div";u=new Element(o);u.adopt(this.options.rowtemplate.clone())}var v=$H(q[i]);$H(v.data).each(function(z,y){var x="."+y;var r=u.getElement(x);if(typeOf(r)!=="null"&&r.get("tag")!=="a"){r.set("html",z)}k++}.bind(this));u.getElement(".fabrik_row").id=v.id;if(typeOf(this.options.rowtemplate)==="string"){var w=u.getElement(".fabrik_row").clone();w.id=v.id;var t=v["class"].split(" ");for(j=0;j<t.length;j++){w.addClass(t[j])}w.inject(e)}else{var s=u.getElement(".fabrik_row");s.inject(e);u.empty()}a++}}}.bind(this));var m=this.list.getElements("tbody");m.setStyle("display","");m.each(function(o){if(!o.hasClass("fabrik_groupdata")){var p=o.getNext();if(typeOf(p)!=="null"){if(p.getElements(".fabrik_row").length===0){o.hide();p.hide()}}}});var b=this.list.getParent(".fabrikDataContainer");var h=this.list.getParent(".fabrikForm").getElement(".emptyDataMessage");if(k===0){if(typeOf(h)!=="null"){h.setStyle("display","");if(h.getParent().getStyle("display")==="none"){h.getParent().setStyle("display","")}if(h.getElement(".emptyDataMessage")){h.getElement(".emptyDataMessage").setStyle("display","")}}}else{if(typeOf(b)!=="null"){b.setStyle("display","")}if(typeOf(h)!=="null"){h.setStyle("display","none")}}if(typeOf(this.form.getElement(".fabrikNav"))!=="null"){this.form.getElement(".fabrikNav").set("html",d.htmlnav)}this.watchAll(true);Fabrik.fireEvent("fabrik.list.updaterows");Fabrik.fireEvent("fabrik.list.update",[this,d])}this.stripe();this.mediaScan();Fabrik.loader.stop("listform_"+this.options.listRef)},mediaScan:function(){if(typeof(Slimbox)!=="undefined"){Slimbox.scanPage()}if(typeof(Lightbox)!=="undefined"){Lightbox.init()}if(typeof(Mediabox)!=="undefined"){Mediabox.scanPage()}},addRow:function(e){var d=new Element("tr",{"class":"oddRow1"});var a={test:"hi"};for(var b in e){if(this.options.headings.indexOf(b)!==-1){var f=new Element("td",{}).appendText(e[b]);d.appendChild(f)}}d.inject(this.tbody)},addRows:function(a){for(i=0;i<a.length;i++){for(j=0;j<a[i].length;j++){this.addRow(a[i][j])}}this.stripe()},stripe:function(){var a=this.list.getElements(".fabrik_row");for(i=0;i<a.length;i++){if(!a[i].hasClass("fabrik___header")){var b="oddRow"+(i%2);a[i].addClass(b)}}},checkEmpty:function(){var a=this.list.getElements("tr");if(a.length===2){this.addRow({label:Joomla.JText._("COM_FABRIK_NO_RECORDS")})}},watchCheckAll:function(b){var a=this.form.getElement("input[name=checkAll]");if(typeOf(a)!=="null"){a.addEvent("click",function(h){var g=this.list.getParent(".fabrikList")?this.list.getParent(".fabrikList"):this.list;var f=g.getElements("input[name^=ids]");c=!h.target.checked?"":"checked";for(var d=0;d<f.length;d++){f[d].checked=c;this.toggleJoinKeysChx(f[d])}}.bind(this))}this.form.getElements("input[name^=ids]").each(function(d){d.addEvent("change",function(f){this.toggleJoinKeysChx(d)}.bind(this))}.bind(this))},toggleJoinKeysChx:function(a){a.getParent().getElements("input[class=fabrik_joinedkey]").each(function(b){b.checked=a.checked})},watchNav:function(h){var g=this.form.getElement("select[name*=limit]");if(g){g.addEvent("change",function(l){var k=Fabrik.fireEvent("fabrik.list.limit",[this]);if(this.result===false){this.result=true;return false}this.doFilter()}.bind(this))}var b=this.form.getElement(".addRecord");if(typeOf(b)!=="null"&&(this.options.ajax_links)){b.removeEvents();var d=(this.options.links.add===""||b.href.contains(Fabrik.liveSite))?"xhr":"iframe";var f=b.href;f+=f.contains("?")?"&":"?";f+="tmpl=component&ajax=1";b.addEvent("click",function(l){l.stop();var k={id:"add."+this.id,title:this.options.popup_add_label,loadMethod:d,contentURL:f,width:this.options.popup_width,height:this.options.popup_height};if(typeOf(this.options.popup_offset_x)!=="null"){k.offset_x=this.options.popup_offset_x}if(typeOf(this.options.popup_offset_y)!=="null"){k.offset_y=this.options.popup_offset_y}Fabrik.getWindow(k)}.bind(this))}if(document.id("fabrik__swaptable")){document.id("fabrik__swaptable").addEvent("change",function(k){window.location="index.php?option=com_fabrik&task=list.view&cid="+k.target.get("value")}.bind(this))}if(typeOf(this.form.getElement(".pagination"))!=="null"){var a=this.form.getElement(".pagination").getElements(".pagenav");if(a.length===0){a=this.form.getElement(".pagination").getElements("a")}a.each(function(e){e.addEvent("click",function(k){k.stop();if(e.get("tag")==="a"){var l=e.href.toObject();this.fabrikNav(l["limitstart"+this.id])}}.bind(this))}.bind(this))}this.watchCheckAll()},updateCals:function(b){var a=["sums","avgs","count","medians"];this.form.getElements(".fabrik_calculations").each(function(d){a.each(function(e){$H(b[e]).each(function(h,f){var g=d.getElement(".fabrik_row___"+f);if(typeOf(g)!=="null"){g.set("html",h)}})})})}});var FbListKeys=new Class({initialize:function(a){window.addEvent("keyup",function(d){if(d.alt){switch(d.key){case Joomla.JText._("COM_FABRIK_LIST_SHORTCUTS_ADD"):var b=a.form.getElement(".addRecord");if(a.options.ajax){b.fireEvent("click")}if(b.getElement("a")){a.options.ajax?b.getElement("a").fireEvent("click"):document.location=b.getElement("a").get("href")}else{if(!a.options.ajax){document.location=b.get("href")}}break;case Joomla.JText._("COM_FABRIK_LIST_SHORTCUTS_EDIT"):fconsole("edit");break;case Joomla.JText._("COM_FABRIK_LIST_SHORTCUTS_DELETE"):fconsole("delete");break;case Joomla.JText._("COM_FABRIK_LIST_SHORTCUTS_FILTER"):fconsole("filter");break}}}.bind(this))}});var FbGroupedToggler=new Class({Implements:Options,options:{collapseOthers:false,startCollapsed:false,bootstrap:false},initialize:function(a,d){var g,e,b,f;if(typeOf(a)==="null"){return}this.setOptions(d);this.container=a;this.toggleState="shown";if(this.options.startCollapsed&&this.options.isGrouped){this.collapse()}a.addEvent("click:relay(.fabrik_groupheading a.toggle)",function(h){if(h.rightClick){return}h.stop();h.preventDefault();if(this.options.collapseOthers){this.collapse()}e=h.target.getParent(".fabrik_groupheading");b=this.options.bootstrap?e.getElement("i"):e.getElement("img");f=b.retrieve("showgroup",true);if(e.getNext()&&e.getNext().hasClass("fabrik_groupdata")){g=e.getNext()}else{g=e.getParent().getNext()}f?g.hide():g.show();this.setIcon(b,f);f=f?false:true;b.store("showgroup",f);return false}.bind(this))},setIcon:function(a,b){if(this.options.bootstrap){if(!b){a.removeClass("icon-arrow-right");a.addClass("icon-arrow-down")}else{a.addClass("icon-arrow-right");a.removeClass("icon-arrow-down")}}else{if(b){a.src=a.src.replace("orderasc","orderneutral")}else{a.src=a.src.replace("orderneutral","orderasc")}}},collapse:function(){this.container.getElements(".fabrik_groupdata").hide();var a=this.options.bootstrap?"i":"img";var b=this.container.getElements(".fabrik_groupheading a "+a);if(b.length===0){b=this.container.getElements(".fabrik_groupheading "+a)}b.each(function(d){d.store("showgroup",false);this.setIcon(d,true)}.bind(this))},expand:function(){this.container.getElements(".fabrik_groupdata").show();var a=this.container.getElements(".fabrik_groupheading a img");if(a.length===0){a=this.container.getElements(".fabrik_groupheading img")}a.each(function(b){b.store("showgroup",true);this.setIcon(b,false)}.bind(this))},toggle:function(){this.toggleState==="shown"?this.collapse():this.expand();this.toggleState=this.toggleState==="shown"?"hidden":"shown"}});var FbListActions=new Class({Implements:[Options],options:{selector:"ul.fabrik_action, .btn-group.fabrik_action",method:"floating",floatPos:"bottom"},initialize:function(b,a){this.setOptions(a);this.list=b;this.actions=[];this.setUpSubMenus();Fabrik.addEvent("fabrik.list.update",function(e,d){this.observe()}.bind(this));this.observe()},observe:function(){if(this.options.method==="floating"){this.setUpFloating()}else{this.setUpDefault()}},setUpSubMenus:function(){if(!this.list.form){return}this.actions=this.list.form.getElements(this.options.selector);this.actions.each(function(d){if(d.getElement("ul")){var e=d.getElement("ul");var h=new Element("div").adopt(e.clone());var a=e.getPrevious();if(a.getElement(".fabrikTip")){a=a.getElement(".fabrikTip")}var b=Fabrik.tips?Fabrik.tips.options:{};var g=Object.merge(Object.clone(b),{showOn:"click",hideOn:"click",position:"bottom",content:h});var f=new FloatingTips(a,g);e.dispose()}})},setUpDefault:function(){this.actions=this.list.form.getElements(this.options.selector);this.actions.each(function(a){if(a.getParent().hasClass("fabrik_buttons")){return}a.fade(0.6);var b=a.getParent(".fabrik_row")?a.getParent(".fabrik_row"):a.getParent(".fabrik___heading");if(b){b.addEvents({mouseenter:function(d){a.fade(0.99)},mouseleave:function(d){a.fade(0.6)}})}})},setUpFloating:function(){var g=false;this.list.form.getElements(this.options.selector).each(function(k){if(k.getParent(".fabrik_row")){if(i=k.getParent(".fabrik_row").getElement("input[type=checkbox]")){g=true;var n=function(r,q,s){if(!r.target.checked){this.hide(r,q)}if(s==="tip"){}};var p=function(q,t){var s=k.getParent();s.store("activeRow",k.getParent(".fabrik_row"));return s}.bind(this.list);var l={position:this.options.floatPos,showOn:"change",hideOn:"click",content:p,heading:"Edit: ",hideFn:function(q){return !q.target.checked},showFn:function(r,q){Fabrik.activeRow=k.getParent().retrieve("activeRow");q.store("list",this.list);return r.target.checked}.bind(this.list)};var o=Fabrik.tips?Object.merge(Object.clone(Fabrik.tips.options),l):l;var m=new FloatingTips(i,o)}}}.bind(this));this.list.form.getElements(".fabrik_select input[type=checkbox]").addEvent("click",function(k){Fabrik.activeRow=k.target.getParent(".fabrik_row")});var e=this.list.form.getElement("input[name=checkAll]");if(typeOf(e)!=="null"){e.store("listid",this.list.id)}var h=function(k){var l=k.getParent(".fabrik___heading");return typeOf(l)!=="null"?l.getElement(this.options.selector):""}.bind(this);var b=Fabrik.tips?Object.clone(Fabrik.tips.options):{};var f=Object.merge(b,{position:this.options.floatPos,html:true,showOn:"click",hideOn:"click",content:h,heading:"Edit all: ",hideFn:function(k){return !k.target.checked},showFn:function(l,k){k.retrieve("tip").click.store("list",this.list);return l.target.checked}.bind(this.list)});var d=new FloatingTips(e,f);if(this.list.form.getElements(".fabrik_actions")&&g){this.list.form.getElements(".fabrik_actions").hide()}if(this.list.form.getElements(".fabrik_calculation")){var a=this.list.form.getElements(".fabrik_calculation").getLast();if(typeOf(a)!=="null"){a.hide()}}}});