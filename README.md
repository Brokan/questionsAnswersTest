## MySQL
Create database, user and set rights:
```
CREATE SCHEMA IF NOT EXISTS questionsanswers;
CREATE USER 'questionsanswers'@'localhost' IDENTIFIED BY 'questionsanswers';
GRANT ALL PRIVILEGES ON questionsanswers.* TO 'questionsanswers'@'localhost';
```

Setup them in .env file.