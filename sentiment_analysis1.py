import sys
import json
from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer

# Check if input is received via stdin
try:
    input_data = sys.stdin.read()
    comments = json.loads(input_data)  # Parse the JSON data into a list
except Exception as e:
    print(f"Error: {str(e)}")
    sys.exit(1)

# Initialize the VADER sentiment analyzer
analyzer = SentimentIntensityAnalyzer()

# Initialize counters for positive and negative comments
positive_count = 0
negative_count = 0

# Perform sentiment analysis on each comment
for comment in comments:
    try:
        sentiment = analyzer.polarity_scores(comment)
        
        # VADER sentiment classification
        # The 'compound' score is what we typically use to determine the overall sentiment
        compound_score = sentiment['compound']
        
        # Classify based on the compound score
        if compound_score >= 0.1:  # Positive if compound score is greater than or equal to 0.05
            positive_count += 1
        elif compound_score <= -0.1:  # Negative if compound score is less than or equal to -0.05
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
