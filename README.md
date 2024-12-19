## Дисциплина: Построение распределенных систем и облачные вычисления

UPD 20.12: Добавлен метод /install создающий базу данных и таблицу с нужными столбцами. Актуальная версия образа miemhomeworkrestachivment2:1.4

### Achievement №3
Docker Pull Command

```bash
docker pull iliyahse/miemhomeworkrestachivment2
```

Страница на [docker Hub](https://hub.docker.com/r/iliyahse/miemhomeworkrestachivment2)

При запуске контейнера из образа `miemhomeworkrestachivment2` необходимо передать следующие переменные окружения:
```yml
    environment:
      hostDB: localhost
      nameDB: test_dev_iot
      userDB: test
      passDB: testpassword
      logPath: ./example.txt
      nMax: 3000
```
Пример `docker-compose.yml` находится в папке **achievement3**.


### Achievement №2
### Команда:
- [Еременко Екатерина](https://github.com/erkath)
- [Коровин Евгений](https://github.com/EvgeniyKorovin1)
- [Лыжин Илья](https://github.com/lyzhinIG)

### Демо

- Для проверки работы можно отправить POST запрос на https://homework.iotdatahub.ru/
- В переменной `number` должно быть число от 0 до 2147683640 (включительно).
- Пример реализации на Python:

```python
import requests

url = "https://homework.iotdatahub.ru"
payload = "number=2147683610"
headers = {
    "Content-Type": "application/x-www-form-urlencoded",
}
response = requests.request("POST", url, data=payload, headers=headers)

print(response.text)
```
Все файлы задания находятся в папке **achievement2**.
