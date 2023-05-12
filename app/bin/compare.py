from sympy import sympify, simplify
from sympy.parsing.latex import parse_latex
import sys
import re

#Replace fractions with rounded decimals
e1l = re.sub(r'\\dfrac{(\d+)}{(\d+)}', lambda match: str(round(int(match.group(1))/int(match.group(2)), 4)), sys.argv[1])
e2l = re.sub(r'\\dfrac{(\d+)}{(\d+)}', lambda match: str(round(int(match.group(1))/int(match.group(2)), 4)), sys.argv[2])

e1 = parse_latex(e1l)
e2 = parse_latex(e2l)

if e1.equals(e2):
    print("true")
else:
    print("false")

