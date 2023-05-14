from sympy import sympify, simplify
from sympy.parsing.latex import parse_latex
import sys
import re

# Replace fractions with decimals rounded to 4 decimal places
def replace_fraction(match):
    numerator = int(match.group(1))
    denominator = int(match.group(2))
    if denominator == 0:
        return "0"
    else:
        return str(round(numerator/denominator, 4))

e1l = re.sub(r'\\dfrac{(\d+)}{(\d+)}', replace_fraction, sys.argv[1])
e2l = re.sub(r'\\dfrac{(\d+)}{(\d+)}', replace_fraction, sys.argv[2])

# Parse LaTeX expressions
e1 = parse_latex(e1l)
e2 = parse_latex(e2l)

# Check if the expressions are equal
if e1.equals(e2):
    print("true")
else:
    print("false")