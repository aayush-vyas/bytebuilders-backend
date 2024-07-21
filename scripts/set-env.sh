#!/bin/bash
mkdir config/jwt
aws s3 cp s3://bytebuilders-env-bucket/backend/bb-env .env
aws s3 cp s3://bytebuilders-env-bucket/backend/private.pem config/jwt/
aws s3 cp s3://bytebuilders-env-bucket/backend/public.pem config/jwt/