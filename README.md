-1. (1 балл) Создать POST-ендпоинт, который принимает ссылку и возвращает json с 5-значным хешем этой ссылки и саму
ссылку. Ссылку мы сохраняем в бд.

0. (1 балл) Создать GET-ендпоинт, который принимает хеш, декодирует его и отдает json с декодированной ссылкой.
1. (1 балл) Добавить ендпоинт, который не декодирует урл, а вместо результата редиректит пользователя на декодированный
   урл (что-т типа gourl?hash).
2. (2 балла) Добавить поиск такого же урла в базе при кодировании и, если найден, то использовать его хеш в ответе. (
   firstOfCreate)
3. (3 балла) Добавить срок жизни (1 НЕДЕЛЯ) закодированного урла, по истечению этого срока (через какое-то время после
   создания) урл не должен декодироваться, а в результате должна выдаваться ошибка.

4. (4 балла) Добавить команду, которая отправляет информацию [урл/дата создания] на указанный в конфиге ендпоинт. Здесь
   нужно учитывать уже отправленные, чтобы не слать всё, а только новые (при повторном запуске).

   Плюсом будет:
1. (2 балла) Добавить в проект тесты.
2. (1 балл) Добавить обработку ошибок.
3. (1 балл) Добавить валидацию входных параметров.