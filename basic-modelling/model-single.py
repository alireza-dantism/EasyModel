from modeller import *
from modeller.automodel import *
#from modeller import soap_protein_od
import sys


env = Environ()
a = AutoModel(env, alnfile='alignment.ali',
              knowns='Template'+sys.argv[1], sequence='Model',
              assess_methods=(assess.DOPE,
                              #soap_protein_od.Scorer(),
                              assess.GA341))
a.starting_model = 1
a.ending_model = int(sys.argv[2])
a.make()


# Get a list of all successfully built models from a.outputs
ok_models = [x for x in a.outputs if x['failure'] is None]

# Rank the models by DOPE score
key = 'DOPE score'
if sys.version_info[:2] == (2,3):
    # Python 2.3's sort doesn't have a 'key' argument
    ok_models.sort(lambda a,b: cmp(a[key], b[key]))
else:
    ok_models.sort(key=lambda a: a[key])

# Get top model
m = ok_models[0]
print(m['name'])