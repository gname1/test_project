
var pattern_topic_switch = /^iot\/bulb(\d+)\/get$/;		// /^iot\/bulb(\d+)\/(get|set)$/;
var pattern_topic_mode = /^iot\/bulb(\d+)\/mode\/get$/;

var switch_arr = [0,1];

/*
var re = /^iot\/bulb(\d+)\/(get|set)$/;
var str = "light/switch";

if (re.test(str)) {
	alert( str.match(re)[1] );
} else {
	alert(' не содержит ');
}
*/


 setInterval(function(){ db_monitoring();	}, 100);
	


// Мониторинг новых данных в бд
function db_monitoring(){
	
	// Определяем кол-во записей в бд
	$.ajax({
		type: "POST",
		url: "core/get_data_row_counter.php",
		dataType: "json",
		success: function(count){
				
				// Если есть новые данные
				if(data_row_counter != count){
					
					data_row_counter++;
					// Обрабатываем каждую строку
					for (var i = data_row_counter; i <= count; i++) {
					   // Получаем строку
					   $.ajax({
							type: "POST",
							url: "core/get_data_row.php",
							dataType: "json",
							data: {'row_id': i},
							success: function(row){
								// Если корректный топик
								
									// Состояние
								if((bulb_id = regex_check(pattern_topic_switch, row.topic)) != -1){
									// Проверяем существование bulb
									
									//if(arr_bulb.includes(Number(bulb_id))){
									//if(Number(bulb_id) in arr_bulb){
										if( arr_bulb.indexOf( Number(bulb_id) ) != -1){
										// Если значение корректно
											if(row.message == 0 || row.message == 1){
													bulb_current_value = $('#bulb'+bulb_id).attr('value');
													if(bulb_current_value != row.message){
													
													// Меняем значение
													$('#bulb'+bulb_id).attr('value',row.message);
													
													// Меняем картинку
													if(Number(row.message) == 1){
														$('#bulb'+bulb_id).attr('src','assets/images/lightbulb_1.png');
														
													}
													else {
														
														$('#bulb'+bulb_id).attr('src','assets/images/lightbulb_0.png');
													}
												}
											}
										
										
									
									}
								}
							
									// Режим
								if((bulb_id = regex_check(pattern_topic_mode, row.topic)) != -1){
										// Если bulb exist
										if( arr_bulb.indexOf( Number(bulb_id) ) != -1){
										// Если значение корректно
											if(row.message == 0 || row.message == 1){
													bulb_current_mode = $('#bulb_mode'+bulb_id).attr('value');
													if(bulb_current_mode != row.message){
													
													// Меняем значение
													$('#bulb_mode'+bulb_id).attr('value',row.message);
													
													// Меняем надпись и Запрещаем ручное упраление если датчик
													if(row.message == 0){
														$('#bulb_mode'+bulb_id).text("Датчик");
														
														// Блокируем
														$('#btn'+bulb_id).attr('disabled', true);
														
														
														
													}
													else{
														$('#bulb_mode'+bulb_id).text("Ручной");
														
														// Разблокируем
														$('#btn'+bulb_id).removeAttr('disabled');
													}
														
												}
											}
										
										
									
									}
								}
							}
						});
					}
					
					data_row_counter = count;
					
				}
		}
	});
	
	
}
	
	
// Проверить принадлежность шаблону и вернуть id
function regex_check(pattern, row){
	
	if (pattern.test(row)) {
		return row.match(pattern)[1];
	} 
	return -1;
}	
	
/*	
// Сменить состояние
function change_switch(bulb_current_id){

	
	// Получаем текущее состояние bulb
	bulb_current_value = $('#bulb'+bulb_current_id).attr('value');
	
	// Определяем новое состояние
	bulb_new_value = (bulb_current_value == 0) ? 1 : 0;
	
	$.ajax({
		type: "POST",
		url: "core/mqtt/publish.php",
		dataType: "json",
		data: {'switch_value': bulb_new_value,
				'bulb_id': bulb_current_id
		},
		success: function(data){
			//alert(data);
		}
	});
	
}
*/


// Сменить состояние
$(document).on('click', '.btn', function (){	

	/*
	// Блокируем кнопку
	$(this).attr('disabled', true);
	btn_id = $(this).attr('id');
	// разблокировка
	setTimeout(function() {
		$('#'+btn_id).removeAttr('disabled');
	}, 1500);
	*/
	
	bulb_current_id = $(this).attr('value');
	
	// Получаем текущее состояние bulb
	bulb_current_value = $('#bulb'+bulb_current_id).attr('value');
	
	// Определяем новое состояние
	bulb_new_value = (bulb_current_value == 0) ? 1 : 0;
	
	// Topic
	topic_switch = "iot/bulb"+bulb_current_id+"/set";
	
	$.ajax({
		type: "POST",
		url: "core/mqtt/publish.php",
		dataType: "json",
		data: {'message': bulb_new_value,
				'bulb_id': bulb_current_id,
				'pub_topic': topic_switch
		},
		success: function(data){
			//alert(data);
		}
	});
});


// Сменить режим
$(document).on('click', '.btn_mode', function (){	
	
	
	// Получаем id bulb
	btn_mode_id = $(this).attr('id');
	var pattern_btn_mode_id = /^bulb_mode(\d+)$/;
	bulb_current_id = regex_check(pattern_btn_mode_id, btn_mode_id);
	
	
	// Получаем текущий режим bulb
	bulb_current_mode = $('#bulb_mode'+bulb_current_id).attr('value');
	
	
	// Определяем новый режим
	bulb_new_mode = (bulb_current_mode == 0) ? 1 : 0;
	
	// Topic
	topic_mode = "iot/bulb"+bulb_current_id+"/mode/set";
	
	$.ajax({
		type: "POST",
		url: "core/mqtt/publish.php",
		dataType: "json",
		data: {'message': bulb_new_mode,
				'bulb_id': bulb_current_id,
				'pub_topic': topic_mode
		},
		success: function(data){
			//alert(data);
		}
	});
	
});
