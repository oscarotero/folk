define(["jquery","selectize"],function(e){function t(e,t){var n=[];for(var r in e)n.push({value:r,label:e[r],search:e[r]});t(n)}return{init:function(n){var r=n.find("select").empty(),i=e("html").data("baseurl")+r.data("source");r.selectize({valueField:"value",labelField:"label",searchField:"search",highlight:!1,load:function(n,r){e.ajax({url:i,type:"GET",dataType:"json",data:{query:n},error:function(){console.error("Error"),r()},success:function(e){t(e,r)}})}});var s=r[0].selectize,o=e(r[0].form),u=o.find(".field-data-entity").val()+":"+o.find(".field-data-id").val();s.load(function(n){e.ajax({url:i,type:"GET",dataType:"json",data:{query:u},error:function(){console.error("Error"),n()},success:function(e){t(e,n);for(var r in e)s.addItem(r,!0)}})})}}});