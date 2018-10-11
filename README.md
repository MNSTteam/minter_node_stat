# minter_node_stat
Рейтинг и статистика мастернод Minter

Основная точка доступа (API_ENDPOINT):
https://monsternode.net


API методы:

Список валидаторов, кандидатов и претендетов:
https://monsternode.net/uptime.php
	
	
Файл candidate_card.php отвечает за формат вывода подробной карточки ноды, используя метод API:
https://monsternode.net/uptime.php?candidate=[NODE_PUBLIC_KEY]

	[NODE_PUBLIC_KEY] = Mp... публичный ключ ноды в сети Minter.

Файл balances.php отвечает за формат вывода статистики начислений и штрафов для адреса, используя метод API:
https://monsternode.net/uptime.php?address=[ADDRESS]

	[ADDRESS] = Mx... адрес кошелька в сети Minter.
