#!/bin/bash

echo "Remove tmp..."
rm -rf tmp
rm -rf tmp2
echo "Create New tmp..."
mkdir tmp
mkdir tmp2
echo "Move images..."
cp ./library/image/* ./tmp/
echo "Resize images..."
cd ./tmp
find -maxdepth 1 -iname "*.jpg" | xargs -l -i convert -resize 200x {} ../tmp2/{}
cd ..
echo "Move new images..."
mv ./tmp2/* ./library/image/
echo "Remove tmp..."
rm -rf tmp
rm -rf tmp2

