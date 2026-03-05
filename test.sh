#!/bin/bash

for i in {1..15}; do 
  echo "Request #$i:"
  response=$(curl -s http://localhost)
  

  if echo "$response" | grep -q "<!DOCTYPE html>"; then
    # Ekstrak container ID dari HTML
    container=$(echo "$response" | grep -oP 'Container: \K[a-f0-9]+')
    echo "Response from PHP-App (Container: $container)"
  else
    # Print text biasa (Flask/Node)
    echo "$response"
  fi
  
  echo "---"
done