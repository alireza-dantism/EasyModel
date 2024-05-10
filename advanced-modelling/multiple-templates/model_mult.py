from modeller import *
from modeller.automodel import *
import sys

str = sys.argv[1]
bhb = str.split("#")

final = ""

for x in (bhb):
    myChain = x.split("-")[1]
    myCode  = x.split("-")[0]
    final   += myCode + myChain + ","


list_1 = final[:-1].split(",")

#'1bdmA','1b8pA'

env = Environ()
a = AutoModel(env, alnfile='Model-mult.ali', knowns=(list_1), sequence='Model')
a.starting_model = 1
a.ending_model = 10
a.make()

