.PHONY: build clean rebuild lint

build:
	./scripts/build.sh

clean:
	./scripts/clean.sh

rebuild:
	./scripts/rebuild.sh

lint:
	PHP_BIN=${PHP_BIN} ./scripts/build.sh
