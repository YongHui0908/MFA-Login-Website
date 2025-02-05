const AWS = require("aws-sdk");
const fs = require("fs");
const path = require("path");

// Configure AWS Rekognition
AWS.config.update({
  region: "us-east-1", // Change to your AWS region
});

const rekognition = new AWS.Rekognition();

/**
 * Convert image file to a Buffer for Rekognition API
 * @param {string} imagePath - Path to the image file
 * @returns {Buffer} - Image buffer
 */
const getImageBuffer = (imagePath) => {
  try {
    return fs.readFileSync(path.resolve(imagePath));
  } catch (error) {
    console.error("Error reading image file:", error);
    throw error;
  }
};

/**
 * Compare two images using AWS Rekognition
 * @param {Buffer} sourceImage - Source image buffer
 * @param {Buffer} targetImage - Target image buffer
 */
const compareFaces = async (sourceImage, targetImage) => {
  const params = {
    SourceImage: {
      Bytes: sourceImage,
    },
    TargetImage: {
      Bytes: targetImage,
    },
    SimilarityThreshold: 90, // Adjust threshold as needed
  };

  try {
    const response = await rekognition.compareFaces(params).promise();

    if (response.FaceMatches.length > 0) {
      console.log("Face Match Found!");
      response.FaceMatches.forEach((match, index) => {
        console.log(`Match ${index + 1}:`);
        console.log(`- Similarity: ${match.Similarity.toFixed(2)}%`);
        console.log(`- Confidence: ${match.Face.Confidence.toFixed(2)}%`);
      });
    } else {
      console.log("No Face Match Found.");
    }
  } catch (error) {
    console.error("Error comparing faces:", error);
  }
};

/**
 * Run the test
 */
(async () => {
  try {
    // Replace with paths to your test images
    const sourceImagePath = "debug_decrypted_image.jpg"; // Source image path
    const targetImagePath = "debug_live_scan_image.jpg"; // Target image path

    console.log("Reading images...");
    const sourceImage = getImageBuffer(sourceImagePath);
    const targetImage = getImageBuffer(targetImagePath);

    console.log("Comparing faces...");
    await compareFaces(sourceImage, targetImage);
  } catch (error) {
    console.error("Test failed:", error);
  }
})();
