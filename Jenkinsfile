pipeline {
    agent any

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
            def scannerHome = tool 'sonarqube'
                withSonarQubeEnv('sonarqube_token') {
                sh """/var/lib/jenkins/tools/hudson.plugins.sonar.SonarRunnerInstallation/sonarqube/bin/sonar-scanner \
                -D sonar.projectVersion=1.0-SNAPSHOT \
                -D sonar.login=admin \
                -D sonar.password=DevOpsHint@123 \
                -D sonar.projectBaseDir=/var/lib/jenkins/workspace/jenkins-sonarqube-pipeline/ \
                    -D sonar.projectKey=project \
                    -D sonar.sourceEncoding=UTF-8 \
                    -D sonar.language=php \
                    -D sonar.sources=project/src/main \
                    -D sonar.tests=project/src/test"""
            }
        }
    }
}