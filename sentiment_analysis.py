import sys
import json
from textblob import TextBlob

# Check if input is received via stdin
try:
    input_data = sys.stdin.read()
    comments = json.loads(input_data)  # Parse the JSON data into a list
except Exception as e:
    print(f"Error: {str(e)}")
    sys.exit(1)

# Initialize counters for positive and negative comments
positive_count = 0
negative_count = 0

# Perform sentiment analysis on each comment
for comment in comments:
    try:
        blob = TextBlob(comment)
        sentiment = blob.sentiment.polarity
        
        # Classify based on polarity
        if sentiment > 0.1:  # Slightly adjust the threshold for positive comments
            positive_count += 1
        elif sentiment < -0.1:  # Adjust the threshold for negative comments
            negative_count += 1
            
    except Exception as e:
        print(f"Error processing comment: {str(e)}")

# Prepare the result
result = {
    "positive_count": positive_count,
    "negative_count": negative_count
}

# Output the result as JSON
print(json.dumps(result))  # Ensure only this is printed
