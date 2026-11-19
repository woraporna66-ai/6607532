
pipeline {
    agent any

    triggers {
        pollSCM('H/2 * * * *')
    }

    options {
        skipDefaultCheckout(true)
        disableConcurrentBuilds()
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/woraporna66-ai/6607532.git'
            }
        }

        stage('Prepare Environment') {
            steps {
                withCredentials([
                    string(credentialsId: 'mysql-root-password',
                           variable: 'MYSQL_ROOT_PASSWORD'),
                    string(credentialsId: 'mysql-password',
                           variable: 'MYSQL_PASSWORD')
                ]) {
                    sh '''
                        set +x
                        umask 077
                        printf '%s\\n' \
                          "MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD" \
                          "MYSQL_DATABASE=sl33z" \
                          "MYSQL_USER=u6607532" \
                          "MYSQL_PASSWORD=$MYSQL_PASSWORD" > .env
                    '''
                }
            }
        }

        stage('Build and Deploy') {
            steps {
                sh '''
                    docker compose config --quiet
                    docker compose up -d --build
                '''
            }
        }

        stage('Verify Deployment') {
            steps {
                sh '''
                    docker compose ps
                    for i in $(seq 1 15); do
                        if curl -fsS http://localhost:8081/; then
                            echo "Deployment successful!"
                            exit 0
                        fi
                        sleep 2
                    done
                    echo "Web application is not responding"
                    exit 1
                '''
            }
        }
    }

    post {
        success {
            echo 'SL33Z deployed successfully!'
        }
        failure {
            echo 'Deployment failed. Please check the logs.'
        }
    }
}

