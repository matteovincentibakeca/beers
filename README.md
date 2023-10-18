# Documentazione per l'Impostazione del Progetto

Questo documento guida l'utente attraverso i passaggi necessari per configurare il progetto utilizzando Docker.

## Prerequisiti

- Avere installato Docker sul proprio sistema. Se non l'hai ancora fatto, puoi scaricarlo da [qui](https://www.docker.com/get-started).

## Passi per la Configurazione

1. **Pull del Repository**

   Inizia clonando il repository sul tuo computer locale.
2. **Lanciare i comandi** 

```bash
git clone URL_DEL_REPOSITORY
cd NOME_DELLA_CARTELLA
docker run -it --tty --rm -v $(pwd):/app -u "$(id -u):$(id -g)" composer install;
docker run -it --tty --rm -v $(pwd):/app -u "$(id -u):$(id -g)" composer run-script post-root-package-install;
docker run -it --tty --rm -v $(pwd):/app -u "$(id -u):$(id -g)" composer run-script post-create-project-cmd;
docker run -it --tty --rm -v $(pwd):/app -w /app -u "$(id -u):$(id -g)" node npm install;
docker run -it --tty --rm -v $(pwd):/app -w /app -u "$(id -u):$(id -g)" node npm run build;
```

