#!/bin/sh
psql -c "DROP DATABASE dbdisco";
psql -c "CREATE DATABASE dbdisco";
psql -c "GRANT ALL PRIVILEGES ON DATABASE dbdisco TO dbdisco";

