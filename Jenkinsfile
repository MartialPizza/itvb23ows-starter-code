pipeline {
    agent any
    tools {
        jdk: "OracleJDK21"
    }
    stages {
        stage("build") {
            steps {
                echo 'building the application...'
            }
        }

        stage("test") {
            steps {
                echo 'testing the application...'
            }
        }

        stage("deploy") {
            steps {
                echo 'deploying the application...'
            }
        }

        stage("Scan") {
            environment {
                scannerHome = tool 'sonar4.8'
            }
            steps {
                withSonarQubeEnv(installationName: 'SonarQube') {
                    sh "${scannerHome}/bin/sonar-scanner"
                }
            }
        }
    }
}