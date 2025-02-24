# Hyperf com Rapadura

## 🍿 Overview

This is a simple example of a project using the Hyperf framework.

## 🚀 Getting Started

### Prerequisites

- Docker 25+
- Docker Compose 2.23+
- Git 2.39+
- GNU Make 3+

### Installation

Clone the repository

```bash
git clone git@github.com:PHPcomRapadura/hyperf-example.git
```

Execute the following command to setup the application

```bash
make setup
```

Use the command up to put it to run

```
make up
```

> The application will be available at http://localhost:9501


### About `docker-compose` / `docker compose`

Configure the environment variables in the your system if you want to use the `docker compose` or other command.

```bash
export COMPOSE_RUNNER="docker compose"
```

## 🛠️ Running the CI/CD pipeline

Execute the following command to run the CI/CD pipeline (this is not running SonarQube)

```bash
make ci
```

To run the tests, execute the following command

```bash
make test
```

Or just

```bash
make test:unit
```

Or

```bash
make test:integration
```

## ✨ References

- [Hyperf](https://hyperf.io/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [GNU Make](https://www.gnu.org/software/make/)
- [Sonar](https://www.sonarcloud.io/)

## 👋 Related projects

- [Swoole na Unha](https://github.com/ricardominze/swoolebootstrap)
- [Super Quiz](https://github.com/PHPcomRapadura/quiz)
