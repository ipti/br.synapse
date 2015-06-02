#!/bin/bash

echo "Remove tmp..."
rm -rf tmp
rm -rf tmp2
echo "Create New tmp..."
mkdir tmp
mkdir tmp2
echo "Move Sounds..."
cp ./library/sound/* ./tmp/
echo "Reduce the Bit-rate..."
cd ./tmp

find -maxdepth 1 -iname "*.mp3" | xargs -l -i lame --mp3input -b 32 {} ../tmp2/{}
cd ..
echo "Move new sounds..."
mv ./tmp2/* ./library/sound/
echo "Remove tmp..."
rm -rf tmp
rm -rf tmp2

