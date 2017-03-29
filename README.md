# Beispiel PHP Queues (RabbitMQ)

## Installation

getestet mit ubuntu/xenial64.

Installation von `rabbitmq-server`, danach die Konfiguration anpassen.  

/etc/rabbitmq/rabbitmq.config

```
[
        {rabbit, [
                {loopback_users, []},
                {tcp_listeners, [{"0.0.0.0", 5672}]}
                ]
        },
        {rabbitmq_management, [
                {listener, [
                        {ip, "0.0.0.0"},
                        {port, 12345}
                ]}
        ]}
].
```

RabbitMQ muss nun neu gestartet werden.

über `http://127.0.0.1:12345/` sollte sich nun der Admin Bereich öffnen.  
Nutzt man eine VM müssen entsprechende Port forwardings eingerichtet werden.  

## Worker und Producer ausprobieren

Bei Bedarf die IP's in worker.php / consumer.php anpassen.

`php producer.php` ausführen, sollte rund 2-5 Sekunden dauern, danach sollten im Admin Bereich RabbitMQ 10.000 Nachrichten angekommen sein.  
`php worker.php` ausführen, hier sollten einige Nachrichten aus der Queue entfernt werden. Der Worker bricht zu einem Prozent mit einer Exception ab um Fehler zu simulieren.

Produktiv würde man z.B. mittels supervisord die Worker starten.  
Eine Beispielkonfiguration liegt vor: `supervisord -n -c supervisord.conf`

## Performance
- Auf meinem lokalen System sind 600 - 900 m/s kein Problem.
- Queues können ohne Probleme auf mehrere hunder tausend Jobs anwachsen.

## Vorteile
- Die Implementation ist selten einfach (wenige Zeilen PHP).
- Treten Fehler auf, wird die Nachricht einfach einem anderen Worker gegeben.
- RabbitMQ ist persistent, egal ob Server / Worker abstürzt, die Nachricht geht nicht verloren.
- AMQP wird von vielen Servern und von fast allen Prgrammiersprachen unterstützt. Nutzt man zudem noch wie in dem Beispiel Protobuf ist man völlig sprachunabhängig.

## Protobuf
Das Beispiel schickt Protobuf Nachrichten hin und her.  
Die Nachrichten sind dadurch kompakt und vorallem versioniert.  
Worker können daher unabhängig voneinander weiterentwickelt werden, ohne das das Serialisierungsformat bricht.  
