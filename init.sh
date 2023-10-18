#!/usr/bin/env sh

docker run -it --tty --rm -v $(pwd):/app -u "$(id -u):$(id -g)" composer install;
docker run -it --tty --rm -v $(pwd):/app -u "$(id -u):$(id -g)" composer run-script post-root-package-install;
docker run -it --tty --rm -v $(pwd):/app -u "$(id -u):$(id -g)" composer run-script post-create-project-cmd;
docker run -it --tty --rm -v $(pwd):/app -w /app -u "$(id -u):$(id -g)" node npm install;
docker run -it --tty --rm -v $(pwd):/app -w /app -u "$(id -u):$(id -g)" node npm run build;
./vendor/bin/sail up -d
