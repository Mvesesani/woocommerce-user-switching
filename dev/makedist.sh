#!/bin/bash
# This script will create a distributable zip file of the plugin
# Author: Realm Digital
# Developer: Twaambo Haamucenje

echo "Creating plugin distributable..."
# Get the directory to work in
DIRECTORY=`dirname "$(readlink -f "$0")"`

# Create some vars
WORKINGDIR=$DIRECTORY/dist
PLUGNAME="woocommerce-user-switching"
TEMPDIR=$WORKINGDIR/$PLUGNAME

cd "${DIRECTORY}"

# Ask for the version of the distributable
read -p "Please enter a version number [1.0.0]: " version
VERSION=${version:-1.0.0}

echo "Thank you."
echo "Readying assets..."
# Ensure destination directory exists
mkdir -p "${WORKINGDIR}"

# Make distributable plugin folder
mkdir -p "${TEMPDIR}"
cp ../README.txt "${TEMPDIR}/README.txt"
cp ../LICENSE.txt "${TEMPDIR}/LICENSE.txt"
cp ../index.php "${TEMPDIR}/index.php"
cp ../uninstall.php "${TEMPDIR}/uninstall.php"
cp ../$PLUGNAME.php "${TEMPDIR}/$PLUGNAME.php"
cp -r ../includes "${TEMPDIR}/includes"

# Move into the distributable directory
cd "${WORKINGDIR}"

echo "Creating zip file..."
# Make the zip distributable
zip -r $PLUGNAME-$VERSION.zip $PLUGNAME

echo "Deleting temporary files..."
# Remove the distributable directory
rm -r "${TEMPDIR}"

echo "Distributable plugin file generated!"
echo "Find the archive here: ${WORKINGDIR}/$PLUGNAME-$VERSION.zip"
