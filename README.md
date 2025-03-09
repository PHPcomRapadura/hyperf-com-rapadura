[![SonarQube Cloud](https://sonarcloud.io/images/project_badges/sonarcloud-highlight.svg)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)

[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=bugs)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=sqale_index)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)

[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=coverage)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=PHPcomRapadura_hyperf-com-rapadura&metric=ncloc)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)

---

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
git clone git@github.com:PHPcomRapadura/hyperf-com-rapadura.git
```

Execute the following command to setup the application

```bash
make setup
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

---

[![Quality gate](https://sonarcloud.io/api/project_badges/quality_gate?project=PHPcomRapadura_hyperf-com-rapadura)](https://sonarcloud.io/summary/new_code?id=PHPcomRapadura_hyperf-com-rapadura)
