pipeline {
    agent any

    stages {
        stage("Scan") {
            withSonarQubeEnv('sonarqube') {
            sh """ 
                sonar-scanner \
            """
            }
        }
    }
}