recipe = {
	'draw': function(div_el){
		var array = new Array();
		html.clearSection(div_el);
		if(sT['recipe_components']===undefined)sT['recipe_components'] = new Object();
		for(var i in sT['item.recipe']){
			recipe.counter = 0;
			array.push(html.t('recipe.main',sT['item.recipe'][i]));
		}
		html.setSection(div_el,array.join(''));
		for(var i in sT['item.recipe']){
			recipe.make_calculator(sT['item.recipe'][i]['id']);
		}
	},

	'make_recipe': function(rbody,recipe_count,parent_element_id,checked){
		var str = '';
		for(var i in rbody){
			if(sT['recipe_components'][rbody[i]['item_id']]==undefined){
				sT['recipe_components'][rbody[i]['item_id']] = new Object();
				sT['recipe_components'][rbody[i]['item_id']] = clone(rbody[i]);
			}
			rbody[i]['recipe_count'] = recipe_count;
			rbody[i]['r_count'] = (rbody[i]['r_count'])?rbody[i]['r_count']:'1';
			rbody[i]['checked'] = (checked==true)?'checked="checked"':'';
			recipe.counter++;
			rbody[i]['this_id'] = 'recipe_'+rbody[i]['recipe_id']+'_'+recipe.counter;
			rbody[i]['parent_id'] = parent_element_id;
			str += html.t('recipe.component',rbody[i]);
		}
		return str;
	},
	
	'make_calculator': function(id){
		var component;
		var component_list = new Object();
		for(var i=0;component=document.getElementsByName('recipe_'+id).item(i);i++){																																						 
			if(component.checked){
				var item_id = component.getAttributeNode('item_id').value;
				var count   = component.getAttributeNode('count').value;
				if(component_list[item_id]!=undefined){
					component_list[item_id]['count'] += Math.abs(count); 
				} else {
					component_list[item_id] = new Object();
					component_list[item_id]['item_id'] = item_id;
					component_list[item_id]['count']   = Math.abs(count);
					component_list[item_id]['name']    = sT['recipe_components'][item_id]['name'];
					component_list[item_id]['price']   = sT['recipe_components'][item_id]['price'];
				}
			}
		}
		html.t('recipe.calculator',{recipe_id:id},id+'_recipe_calculator');
		
		var component_list_html = '<table border="0" cellpadding="3" cellspacing="0">';
		for(var i in component_list){
			component_list_html += html.t('recipe.calculator_element',component_list[i]);
		}
		component_list_html += '</table>';
		html.setSection(id+'_calculator_body',component_list_html);
		recipe.calculate({recipe_id:id});
	},
	
	'change_component': function(vars){
		sT.recipe_components[vars.item_id].price = vars.price;
	},
	
	'calculate': function(vars){
		var id = vars.recipe_id;
		var component;
		var total_price = 0;
		for(var i=0;component=document.getElementsByName('recipe_'+id).item(i);i++){
			if(component.checked){
				var item_id = component.getAttributeNode('item_id').value;
				var count   = component.getAttributeNode('count').value;
				total_price += sT['recipe_components'][item_id]['price']*count;
			}
		}
		html.setSection(id+'_calculator_result',total_price);
	},
	
	'change_components': function(recipe_id,checkbox){
		recipe_no_check = new Object();
		if(checkbox.checked){//галочку нажали
			if(recipe.getParent(checkbox)){//у галочки есть родитель
				var el = checkbox;
				while(el=recipe.getParent(el)){//идём вверх по родителям галочки и ищем нажатого предка.
					recipe_no_check[el.id] = true;//мы помечаем всех родителей галочки как не подлежащих нажиманию(так-как сама галочка должна быть нажата)
					if(el.checked){//если мы встретили нажатого предка, мы будем строить дерево от него
						checkbox = el;
						break;
					}
				}
				recipe.putChecks(checkbox);//checkbox - это сама галочка если у неё нет нажатых предков или её нажатый предок если он есть.
			} else recipe.putChecks(checkbox);//это корневая галочка.		
		} else {//галочку отжали
			if(recipe.hasChilds(checkbox)){//у галочки есть дети
				recipe_no_check[checkbox.id] = true;
				recipe.putChecks(checkbox);
			} else {//у галочки нет детей
				if(recipe.getParent(checkbox)){//нет детей но есть родитель
					checkbox = recipe.getParent(checkbox);
					recipe.putChecks(checkbox);
				} else {//нет ни детей не родителя. такая галочка всегда должна быть нажата.
					checkbox.checked = true;
				}
			}
		}
		recipe.make_calculator(recipe_id);
	},
	
	'getParent': function(checkbox){
		var parent_id = checkbox.getAttributeNode('parent_id').value;
		var recipe_id = checkbox.getAttributeNode('name').value;
		return (parent_id!=recipe_id)?document.getElementById(parent_id):null;
	},
	
	'hasChilds': function(checkbox){
		var has_childs = false;
		var recipe_id = checkbox.getAttributeNode('name').value;
		for(var i=0;el=document.getElementsByName(recipe_id).item(i);i++){
				var parent_id = el.getAttributeNode('parent_id').value;
				if(parent_id==checkbox.id){
					has_childs = true;
					break;
				}
			}
		return has_childs;
	},
	
	'putChecks': function(checkbox){
		if(recipe_no_check[checkbox.id]!=true){
			checkbox.checked = true;
			recipe.clearChecks(checkbox);
		} else {
			checkbox.checked = false;
			var recipe_id = checkbox.getAttributeNode('name').value;
			for(var i=0;el=document.getElementsByName(recipe_id).item(i);i++){
				var parent_id = el.getAttributeNode('parent_id').value;
				if(parent_id==checkbox.id)recipe.putChecks(el);
			}
		}
		
	},
	
	'clearChecks': function(checkbox){
		var container = document.getElementById(checkbox.id+'_body');
		for (var i=0;el=container.getElementsByTagName('INPUT').item(i);i++){
			el.checked = false;
		}
	}
}
l2jz.checkScriptVersion('bc8fdb5dc8e4ba0');