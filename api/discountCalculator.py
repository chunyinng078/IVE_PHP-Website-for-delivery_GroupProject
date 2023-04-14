from flask import Flask
from datetime import datetime as dt

app = Flask(__name__)

@app.route("/api/discountCalculator/<accountCreationDate>")
def process(accountCreationDate=None):
    # processing of request data goes here ...
    DAYS_IN_ONE_YEAR = 365.25
    startDate = dt.strptime(accountCreationDate, "%Y-%m-%d")  # new datetime parsed from a string
    now = dt.today()  # Construct a date from time.time()
    days = (now - startDate).days  # number of days between two dates using the days property
    years = int(days / DAYS_IN_ONE_YEAR)  # cast to 'int' type
    if years > 3:
        rate=0.3
    elif years >2:
        rate=0.2
    elif years >1:
        rate=0.1
    else:
        rate=0


    response_data = {"discountRate": rate}
    return response_data

if __name__ == "__main__":
    app.run(debug=True,
            host='127.0.0.1',
            port=8080)
