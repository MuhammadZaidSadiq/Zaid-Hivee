pipeline {
    agent any

    environment {
        COMPOSE_PROJECT_NAME = 'bookhive'
    }

    stages {
        stage('Build') {
            steps {
                echo 'Building Docker images for frontend and backend...'
                //sh 'docker compose build'
                sh '''
                docker compose build
                docker tag bookhive-backend:latest bookhive-backend:v${BUILD_NUMBER}
                docker tag bookhive-frontend:latest bookhive-frontend:v${BUILD_NUMBER}
                '''
            }
        }

        stage('Test') {
            steps {
                echo 'Checking PHP syntax of all backend files...'
                sh '''
                docker run --rm bookhive-backend:latest sh -c 'for f in /var/www/html/*.php; do php -l "$f" || exit 1; done'
                '''
            }
        }

        stage('Deploy') {
            steps {
                echo 'Deploying the 3-tier application...'
                sh 'docker compose up -d'
            }
        }

        stage('Verify') {
            steps {
                sh '''
                for i in $(seq 1 18); do
                  if curl -s http://localhost/login.php | grep -q "Welcome back"; then
                    echo "BookHive is live!"
                    exit 0
                  fi
                  echo "Waiting for the app to start..."
                  sleep 5
                done
                echo "App did not respond in time"
                exit 1
                '''
            }
        }
    }
}
