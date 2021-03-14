(()=>{"use strict";var e={2803:(e,t,a)=>{function l(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function n(e,t){for(var a=0;a<t.length;a++){var l=t[a];l.enumerable=l.enumerable||!1,l.configurable=!0,"value"in l&&(l.writable=!0),Object.defineProperty(e,l.key,l)}}function i(e,t,a){return t&&n(e.prototype,t),a&&n(e,a),e}var o=function(){function e(){l(this,e)}return i(e,null,[{key:"arrayGet",value:function(e,t){var a,l=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;try{a=e[t]}catch(e){return l}return null==a&&(a=l),a}},{key:"stringToSlug",value:function(e,t){return t=t||"-",e.toString().toLowerCase().replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi,"a").replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi,"e").replace(/i|í|ì|ỉ|ĩ|ị/gi,"i").replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi,"o").replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi,"u").replace(/ý|ỳ|ỷ|ỹ|ỵ/gi,"y").replace(/đ/gi,"d").replace(/\s+/g,t).replace(/[^\w\-]+/g,"").replace(/\-\-+/g,t).replace(/^-+/,"").replace(/-+$/,"")}}]),e}(),r=function(){function e(){l(this,e),this.$body=$("body"),this.RULES_GROUP_TEMPLATE_HTML=$("#rules_group_template").html();var t=this;this.$body.on("submit",".form-update-field-group",(function(){var e=JSON.stringify(t.exportRulesToJson()),a=JSON.stringify(t.exportFieldsToJson());$("#custom_fields_rules").html(e).val(e),$("#custom_fields").html(a).val(a)})),$("#custom_fields_rules").length>0&&(this.handleRules(),this.handleFieldGroups())}return i(e,[{key:"handleRules",value:function(){var e=this,t=$.parseJSON($("#custom_fields_rules").val()),a=$(e.RULES_GROUP_TEMPLATE_HTML),l=$("#rules_line_group_template").html(),n=$(".line-group-container");e.$body.on("click",".location-add-rule",(function(e){e.preventDefault();var t=$(e.currentTarget),i=a.clone();if(t.hasClass("location-add-rule-and"))t.closest(".line-group").append(i);else{var o=$(l);o.append(i),n.append(o)}i.find(".rule-a").trigger("change")})),e.$body.on("change",".rule-a",(function(e){e.preventDefault();var t=$(e.currentTarget),a=t.closest(".rule-line");a.find(".rules-b-group select").addClass("hidden"),a.find('.rules-b-group select[data-rel="'+t.val()+'"]').removeClass("hidden")})),e.$body.on("click",".remove-rule-line",(function(e){e.preventDefault();var t=$(e.currentTarget),a=t.closest(".rule-line"),l=t.closest(".line-group");l.find(".rule-line").length<2?l.remove():a.remove()})),t.length<1?$(".location-add-rule").trigger("click"):t.forEach((function(e){var t=$(l);e.forEach((function(e){var l=a.clone();l.find(".rule-a").val(e.name),l.find(".rule-type").val(e.type),l.find('.rule-b:not([data-rel="'+e.name+'"])').addClass("hidden"),l.find('.rule-b[data-rel="'+e.name+'"]').val(e.value),t.append(l)})),n.append(t)}))}},{key:"handleFieldGroups",value:function(){var e=this,t=$.parseJSON($("#custom_fields").val()),a=[],l=$("#_new-field-source_template").html(),n=$("#_options-repeater_template").html(),i=$("#_options-defaultvalue_template").html(),r=$("#_options-defaultvaluetextarea_template").html(),s=$("#_options-placeholdertext_template").html(),u=$("#_options-wysiwygtoolbar_template").html(),d=$("#_options-selectchoices_template").html(),p=$("#_options-buttonlabel_template").html(),c=$("#_options-rows_template").html(),f=function(e){var t="";switch(e){case"text":case"email":case"password":case"number":t+=i+s;break;case"image":case"file":t+="";break;case"textarea":t+=r+s+c;break;case"wysiwyg":t+=r+u;break;case"select":t+=d+i;break;case"checkbox":case"radio":t+=d;break;case"repeater":t+=n+p}return t},v=function(e){return l.replace(/___options___/gi,f(e||"text"))};e.$body.on("click",".show-item-details",(function(e){e.preventDefault();var t=$(e.currentTarget).closest("li");$(e.currentTarget).toggleClass("active"),t.toggleClass("active")})),e.$body.on("click",".btn-close-field",(function(e){e.preventDefault();var t=$(e.currentTarget).closest("li");t.toggleClass("active"),t.find("> .field-column .show-item-details").toggleClass("active")})),e.$body.on("click",".btn-add-field",(function(e){e.preventDefault();var t=$(e.currentTarget).closest(".add-new-field").find("> .sortable-wrapper"),a=$(v());t.append(a),a.find(".line[data-option=title] input[type=text]").focus(),function(e,t){e.attr("data-position",e.index()+1)}(a),a.find(".sortable-wrapper").sortable()})),e.$body.on("change",".change-field-type",(function(e){e.preventDefault();var t=$(e.currentTarget);t.closest(".item-details").find("> .options").html(f(t.val()))})),e.$body.on("change blur",".line[data-option=slug] input[type=text]",(function(e){var t=$(e.currentTarget),a=o.stringToSlug(t.val(),"_");t.closest(".line").closest(".ui-sortable-handle").find("> .field-column .field-slug").text(a),t.val(a)})),e.$body.on("change blur",".line[data-option=type] select",(function(e){var t=$(e.currentTarget),a=o.stringToSlug(t.val(),"_");t.closest(".line").closest(".ui-sortable-handle").find("> .field-column .field-type").text(t.find('option[value="'+a+'"]').text()),t.val(a)})),e.$body.on("change blur",".line[data-option=title] input[type=text]",(function(e){var t=$(e.currentTarget),a=t.closest(".line"),l=a.find("~ .line[data-option=slug] input[type=text]"),n=t.val();a.closest(".ui-sortable-handle").find("> .field-column .field-label").text(n),l.val()||l.val(o.stringToSlug(n,"_")).trigger("change")})),$("#deleted_items").val(""),e.$body.on("click",".btn-remove",(function(e){e.preventDefault();var t=$(e.currentTarget).closest(".ui-sortable-handle"),l=t.parent();a.push(t.data("id")),t.animate({top:-60,left:60,opacity:.3},300,(function(){t.remove(),l.find("> li").each((function(e,t){var a=e+1;$(t).attr("data-position",a)}))})),$("#deleted_items").val(JSON.stringify(a))})),function e(t,a){a.sortable(),t.forEach((function(t,l){var n=$(v(t.type||"text"));n.data("id",t.id||0),n.find(".line[data-option=type] select").val(o.arrayGet(t,"type","text")),n.find(".line[data-option=title] input").val(o.arrayGet(t,"title","")),n.find(".line[data-option=slug] input").val(o.arrayGet(t,"slug","")),n.find(".line[data-option=instructions] textarea").val(o.arrayGet(t,"instructions","")),n.find(".line[data-option=defaultvalue] input").val(o.arrayGet(t.options,"defaultValue","")),n.find(".line[data-option=defaultvaluetextarea] textarea").val(o.arrayGet(t.options,"defaultValueTextarea","")),n.find(".line[data-option=placeholdertext] input").val(o.arrayGet(t.options,"placeholderText","")),n.find(".line[data-option=wysiwygtoolbar] select").val(o.arrayGet(t.options,"wysiwygToolbar","basic")),n.find(".line[data-option=selectchoices] textarea").val(o.arrayGet(t.options,"selectChoices","")),n.find(".line[data-option=buttonlabel] input").val(o.arrayGet(t.options,"buttonLabel","")),n.find(".line[data-option=rows] input").val(o.arrayGet(t.options,"rows","")),n.find(".field-label").html(o.arrayGet(t,"title","Text")),n.find(".field-slug").html(o.arrayGet(t,"slug","text")),n.find(".field-type").html(o.arrayGet(t,"type","text")),n.removeClass("active"),n.attr("data-position",l+1),e(t.items,n.find(".sortable-wrapper")),a.append(n)}))}(t,$(".sortable-wrapper"))}},{key:"exportRulesToJson",value:function(){var e=[];return $(".custom-fields-rules .line-group-container .line-group").each((function(t,a){var l=$(a),n=[];l.find(".rule-line").each((function(e,t){var a=$(t),l={name:a.find(".rule-a").val(),type:a.find(".rule-type").val(),value:a.find(".rule-b:not(.hidden)").val()};n.push(l)})),n.length>0&&e.push(n)})),e}},{key:"exportFieldsToJson",value:function(){var e=[];return function e(t,a){t.each((function(t,l){var n={},i=$(l);n.id=i.data("id")||0,n.title=i.find("> .item-details > .line[data-option=title] input[type=text]").val()||null,n.slug=i.find("> .item-details > .line[data-option=slug] input[type=text]").val()||null,n.instructions=i.find("> .item-details > .line[data-option=instructions] textarea").val()||null,n.type=i.find("> .item-details > .line[data-option=type] select").val()||null,n.options={defaultValue:i.find("> .item-details > .options > .line[data-option=defaultvalue] input[type=text]").val()||null,defaultValueTextarea:i.find("> .item-details > .options > .line[data-option=defaultvaluetextarea] textarea").val()||null,placeholderText:i.find("> .item-details > .options > .line[data-option=placeholdertext] input[type=text]").val()||null,wysiwygToolbar:i.find("> .item-details > .options > .line[data-option=wysiwygtoolbar] select").val()||null,selectChoices:i.find("> .item-details > .options > .line[data-option=selectchoices] textarea").val()||null,buttonLabel:i.find("> .item-details > .options > .line[data-option=buttonlabel] input[type=text]").val()||null,rows:i.find("> .item-details > .options > .line[data-option=rows] input[type=number]").val()||null},n.items=[],e(i.find("> .item-details > .options > .line[data-option=repeater] > .col-9 > .add-new-field > .sortable-wrapper > .ui-sortable-handle"),n.items),a.push(n)}))}($("#custom_field_group_items > .ui-sortable-handle"),e),e}}]),e}();jQuery(window).on("load",(function(){new r}))}},t={};function a(l){if(t[l])return t[l].exports;var n=t[l]={exports:{}};return e[l](n,n.exports,a),n.exports}a.d=(e,t)=>{for(var l in t)a.o(t,l)&&!a.o(e,l)&&Object.defineProperty(e,l,{enumerable:!0,get:t[l]})},a.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),a(2803)})();
