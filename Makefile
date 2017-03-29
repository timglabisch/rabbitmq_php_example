proto:
	protoc --php_out=src/Generated jobs.proto

worker:
	supervisord -n -c supervisord.conf