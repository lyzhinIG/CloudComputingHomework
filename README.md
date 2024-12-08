## Дисциплина: Построение распределенных систем и облачные вычисления

### achievement №2
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

### achievement №3
Docker Pull Command
`docker pull iliyahse/miemhomeworkrestachivment2`
[docker Hub](https://hub.docker.com/r/iliyahse/miemhomeworkrestachivment2)

При запуске контейнера из образа `miemhomeworkrestachivment2` необходимо передать следующие переменные окружения:
```yml
    environment:
      hostDB: localhost
      nameDB: test_dev_iot
      userDB: test
      passDB: testpassword
      logPath: ./example.txt
```
