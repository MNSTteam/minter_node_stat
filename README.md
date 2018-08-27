# minter_node_stat
Рейтинг и статистика мастернод Minter

В _config.js необходимо указать свой public key (если его нет - оставить значение пустым) и адрес сервера, для запросов к API.

	DOMAIN - Ваш http(s)-адрес домена, где размещен сервис рейтинга мастернод (можно оставить пустым).

Основная точка доступа (API_ENDPOINT):
https://monsternode.net


API методы:

https://monsternode.net/api.php?sort=[SORT]&stype=[asc|desc]

	[SORT]
	
	total_stake - сортировка по объему стейка ноды и по статусу (default)

	status - сортировка по статусу ноды

	comission - сортировка по размеру комиссии ноды
	
	delegators - сортировка по количеству делегатов ноды
	
	uptime - сортировка по показателю отказоустойчивости ноды
	
	
Файл candidate_card.php отвечает за формат вывода подробной карточки ноды, используя метод API:
https://monsternode.net/api.php?candidate=[NODE_PUBLIC_KEY]

	[NODE_PUBLIC_KEY] = Mp... публичный ключ ноды.


